<?php
include '../global/session.php';
include '../global/dbConnection.php';


$username = $_SESSION['username'];
$role = $_SESSION['role'];

// search user
if (isset($_GET['q'])) {
    header('Content-Type: application/json');

    $q = mysqli_real_escape_string($connection, trim($_GET['q']));
    if ($q === '') {
        echo json_encode([]);
        exit;
    }

    $query = " SELECT l.login_username AS username, COALESCE(u.user_name, s.staff_name, l.login_username) AS display_name
                FROM tbl_login l
                LEFT JOIN tbl_user_info u ON u.user_username = l.login_username
                LEFT JOIN tbl_staff_info s ON s.staff_username = l.login_username
                WHERE l.login_username LIKE '%$q%' AND l.login_username != '$username' LIMIT 10
            ";

    $result = mysqli_query($connection, $query);
    $users = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }

    echo json_encode($users);
    exit;
}


// send message
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message_content'])) {
    $receiver = $_POST['receiver'] ?? '';
    $content  = trim($_POST['message_content'] ?? '');

    if ($receiver && $content !== '') {
        $content = mysqli_real_escape_string($connection, $content);

        mysqli_query($connection, "INSERT INTO tbl_message (message_sender, message_receiver, message_content, message_status) VALUES ('$username', '$receiver', '$content', 'UNSEEN')");

        $nameQuery = "
                        SELECT COALESCE(u.user_name, s.staff_name, l.login_username) AS display_name
                        FROM tbl_login l
                        LEFT JOIN tbl_user_info u ON u.user_username = l.login_username
                        LEFT JOIN tbl_staff_info s ON s.staff_username = l.login_username
                        WHERE l.login_username = '$receiver' LIMIT 1
                    ";

        $nameResult = mysqli_query($connection, $nameQuery);
        $nameRow = mysqli_fetch_assoc($nameResult);

        echo json_encode([
            'status' => 'success',
            'display_name' => $nameRow['display_name']
        ]);
    } else {
        echo json_encode(['status' => 'error']);
    }
    exit;
}


// seen message
$chatWith = $_GET['chat_with'] ?? null;
if ($chatWith) {
    mysqli_query($connection, "UPDATE tbl_message SET message_status = 'SEEN' WHERE message_sender = '$chatWith' AND message_receiver = '$username' AND message_status = 'UNSEEN'");
}

// chat list
$chatListQuery = "
                    SELECT 
                        l.login_username AS username,
                        COALESCE(u.user_name, s.staff_name, l.login_username) AS display_name,
                        SUM(
                            CASE 
                                WHEN m.message_receiver = '$username'
                                AND m.message_sender = l.login_username
                                AND m.message_status = 'UNSEEN'
                                THEN 1 ELSE 0
                            END
                        ) AS unseen_count
                    FROM tbl_message m
                    JOIN tbl_login l
                        ON l.login_username = CASE
                            WHEN m.message_sender = '$username' THEN m.message_receiver
                            ELSE m.message_sender
                        END
                    LEFT JOIN tbl_user_info u ON u.user_username = l.login_username
                    LEFT JOIN tbl_staff_info s ON s.staff_username = l.login_username
                    WHERE m.message_sender = '$username'
                    OR m.message_receiver = '$username'
                    GROUP BY l.login_username, display_name
                    ORDER BY unseen_count DESC, MAX(m.message_created_at) DESC
                ";
$chatListResult = mysqli_query($connection, $chatListQuery);

//load message in window
$messageResult = null;
if ($chatWith) {
    $messageQuery = "   SELECT * FROM tbl_message WHERE (message_sender = '$username' AND message_receiver = '$chatWith') OR (message_sender = '$chatWith' AND message_receiver = '$username') 
                        ORDER BY message_created_at ASC";
    $messageResult = mysqli_query($connection, $messageQuery);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Chat</title>

<link rel="stylesheet" href="../global/main.css">
<link rel="stylesheet" href="../global/menu.css">
<link rel="stylesheet" href="../global/footer.css">
<link rel="stylesheet" href="chat.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bowlby+One&family=Ultra&display=swap" rel="stylesheet">
</head>




<body class="<?= (isset($_GET['chat_with']) ? 'chat-open' : '') ?>">

<?php
$basePath = dirname(__DIR__);

switch ($role) {
    case 'ADMIN': 
        include $basePath . '/admin/adminMenu.php'; 
        break;
    // case 'STAFF': 
    //     include $basePath . '/staff/staffMenu.php'; 
    //     break;
    // case 'DRIVER': 
    //     include $basePath . '/driver/driverMenu.php'; 
    //     break;
    // default: 
    //     include $basePath . '/user/userMenu.php';
}
?>

<main>
<div class="chat-container">

    <div class="chat-left">
        <div class="chat-left-top"> 
            <span class="chat-title"><i class="fa-regular fa-comment-dots"></i> Chat List </span>
            <button><i class="fa-solid fa-plus"></i> Contact</button>
        </div>

        <div class="chat-list">
        <?php while ($row = mysqli_fetch_assoc($chatListResult)): ?>
            <a href="?chat_with=<?= $row['username'] ?>" class="chat-user <?= ($row['username'] === $chatWith) ? 'active' : '' ?>" data-username="<?= $row['username'] ?>">
                <p class="chat-user-username"><?= $row['username'] ?></p>
                <p class="chat-user-name"><?= htmlspecialchars($row['display_name'] ?? 'Unknown') ?></p>
                <?php if ($row['unseen_count'] > 0): ?>
                    <span class="unseen-dot"><i class="fa-solid fa-bell"></i></span>
                <?php endif; ?>
            </a>
        <?php endwhile; ?>
        </div>
    </div>

    <div class="chat-right">
    <?php if ($chatWith): ?>
        <div class="chat-user-header">
            <button id="mobileBackBtn"><i class="fa-solid fa-arrow-left"></i></button>
            <img src="../upload/user_profile.png">
            <p><?= htmlspecialchars($chatWith)?></p>
        </div>

        <div class="chat-messages">
        <?php while ($msg = mysqli_fetch_assoc($messageResult)):?>
            <div class="chat-message <?= ($msg['message_sender'] === $username) ? 'my-message' : 'their-message' ?>">
                <p><?= htmlspecialchars($msg['message_content']) ?></p>
                <span class="send-time"><?= $msg['message_created_at'] ?></span>
            </div>
        <?php endwhile; ?>
        </div>

        <form id="chat-form" autocomplete="off">
            <input type="text" name="message_content" autocomplete="off" placeholder="Type something here...">
            <input type="hidden" name="receiver" value="<?= htmlspecialchars($chatWith) ?>">
            <button type="submit" id="chat-send-btn"><i class="fa-solid fa-paper-plane"></i></button>
        </form>

    <?php else: ?>
        <div class="chat-start">
            Select a chat to start messaging
        </div>
    <?php endif; ?>
    </div>

    <div class="chat-add-contact" style="display: none;">
        <input type="text" id="searchUser" placeholder="Search username...">
        <div id="searchResults"></div>
    </div>

</div>
</main>

<?php include '../global/footer.php'; ?>

<script>

    // auto scroll the chat chatWin
    const chatWin = document.querySelector('.chat-messages');
    if(chatWin) chatWin.scrollTop = chatWin.scrollHeight;



    // sent message
    const form = document.getElementById('chat-form');
    if(form){
        form.addEventListener('submit', e => {
            e.preventDefault();
            const fd = new FormData(form);
            const msg = fd.get('message_content').trim();
            const receiver = fd.get('receiver');
            if(!msg || !receiver) return;

            fetch('chat.php', {method:'POST', body: fd})
                .then(response=>response.json())
                .then(data=>{
                    if(data.status==='success'){
                        const div = document.createElement('div');
                        div.className='chat-message my-message';
                        div.innerHTML=`<p>${msg}</p><span class="send-time">just now</span>`;
                        chatWin.appendChild(div);
                        chatWin.scrollTop=chatWin.scrollHeight;
                        form.reset();

                        const chatList = document.querySelector('.chat-list');
                        let userItem=[...chatList.querySelectorAll('.chat-user')].find(el=>el.dataset.username===receiver);
                        document.querySelectorAll('.chat-user.active').forEach(el=>el.classList.remove('active'));
                        if(!userItem){
                            userItem = document.createElement('a');
                            userItem.href = `?chat_with=${receiver}`;
                            userItem.className = 'chat-user active';
                            userItem.dataset.username = receiver;
                            userItem.innerHTML = `
                                <p class="chat-user-username">${receiver}</p>
                                <p class="chat-user-name">${data.display_name}</p>
                            `;
                            chatList.prepend(userItem);
                        } else {
                            userItem.classList.add('active');
                            chatList.prepend(userItem);
                        }
                    }
                });
        });
    }



    //seen message
    document.querySelectorAll('.chat-user').forEach(chat=>{
        chat.addEventListener('click', ()=>{
            const dot = chat.querySelector('.unseen-dot');
            if(dot) dot.remove();
        });
    });



    // mobile mode add contact
    const contactBtn = document.querySelector('.chat-left-top button');
    if(contactBtn){
        contactBtn.addEventListener('click', () => {
            const chatRight = document.querySelector('.chat-right');
            const addContact = document.querySelector('.chat-add-contact');
            const chatList = document.querySelector('.chat-list');
            const searchInput = document.getElementById('searchUser');
            const searchResults = document.getElementById('searchResults');

            const isOpen = document.body.classList.contains('add-contact-open');

            if (!isOpen) {
                document.body.classList.add('add-contact-open');
                addContact.style.display = 'flex';
                chatRight.style.display = 'none';
                chatList.style.display = 'none';
                searchInput.value = '';
                searchResults.innerHTML = '';
                searchInput.focus();
                contactBtn.innerHTML = '<i class="fa-solid fa-xmark"></i> Cancel';
            } else {
                document.body.classList.remove('add-contact-open');
                addContact.style.display = 'none';
                chatList.style.display = 'flex';
                contactBtn.innerHTML = '<i class="fa-solid fa-plus"></i> Contact';
            }
        });
    }

    //search user
    const searchInput = document.getElementById('searchUser');
    if(searchInput){
        searchInput.addEventListener('input', ()=>{
            const keyword = searchInput.value.trim();
            if(!keyword){ 
                const searchResults = document.getElementById('searchResults');
                searchResults.innerHTML = '';
                return; 
            }

            fetch(`chat.php?q=${encodeURIComponent(keyword)}`)
                .then(r => r.json())
                .then(users => {
                    const searchResults = document.getElementById('searchResults');

                    searchResults.innerHTML = users.map(u => `<div class="user-result" data-username="${u.username}" data-name="${u.display_name}">${u.username} (${u.display_name})</div>`).join('');
                    document.querySelectorAll('.user-result').forEach(el=>{
                        el.addEventListener('click', ()=>{
                            window.location.href=`chat.php?chat_with=${el.dataset.username}`;
                        });
                    });
                });
        });
    }

    // mobile mode js
    const backBtn = document.getElementById('mobileBackBtn');
    const chatRight = document.querySelector('.chat-right');

    document.querySelectorAll('.chat-user').forEach(user => {
        user.addEventListener('click', () => {
            user.classList.add('active');

            if (window.innerWidth <= 560) {
                document.body.classList.add('chat-open');
                if (chatRight) chatRight.style.display = 'block';
            }
        });
    });

    if (backBtn) {
        backBtn.addEventListener('click', () => {
            document.body.classList.remove('chat-open');
            if (chatRight) chatRight.style.display = 'none';

            document.querySelectorAll('.chat-user.active').forEach(el => el.classList.remove('active'));

            if (chatWin) chatWin.innerHTML = '';

            const url = new URL(window.location);
            url.searchParams.delete('chat_with');
            window.history.replaceState({}, '', url);
        });
    }
        
</script>
</body>
</html>
