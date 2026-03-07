<?php
include("tools/userHeaderName.php"); 

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: ../login.php");
    exit;
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>UCA Connect – Messages</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="font-sans bg-gray-50 h-screen flex flex-col">

  <!-- TOP BAR -->
 <?php
  include("tools/header.php");
  ?>

  <div class="flex flex-1 overflow-hidden">

    <!-- SIDEBAR -->
    <div class="w-56 border-r border-gray-200 flex flex-col justify-between py-6 bg-white flex-shrink-0">
      <nav class="flex flex-col">
        <a href="01-dashboard.php"   class="flex items-center gap-2.5 px-6 py-2.5 text-sm text-gray-900 border-r-4 border-transparent hover:bg-gray-100 no-underline transition-colors">Dashboard</a>
        <a href="02-find-alumni.php" class="flex items-center gap-2.5 px-6 py-2.5 text-sm text-gray-900 border-r-4 border-transparent hover:bg-gray-100 no-underline transition-colors">Find Alumni</a>
        <a href="04-connections.php" class="flex items-center gap-2.5 px-6 py-2.5 text-sm text-gray-900 border-r-4 border-transparent hover:bg-gray-100 no-underline transition-colors">Connections</a>
        <a href="05-messages.php"    class="flex items-center gap-2.5 px-6 py-2.5 text-sm font-semibold text-blue-600 bg-blue-50 border-r-4 border-blue-600 no-underline">Messages</a>
        <a href="06-stories.php"     class="flex items-center gap-2.5 px-6 py-2.5 text-sm text-gray-900 border-r-4 border-transparent hover:bg-gray-100 no-underline transition-colors">Stories</a>
      </nav>
      <a href="settings.php" class="flex items-center gap-2.5 px-6 py-2.5 text-sm text-gray-500 no-underline">⚙️ Profile &amp; Settings</a>
    </div>

    <!-- CONVERSATIONS LIST -->
    <div class="w-80 border-r border-gray-200 flex flex-col bg-white flex-shrink-0">
      <div class="px-4 pt-5 pb-3">
        <h2 class="text-lg font-bold text-gray-900 mb-3">Messages</h2>
        <div class="flex items-center bg-gray-50 border border-gray-200 rounded-lg px-3 py-1.5 gap-2 mb-3">
          <span class="text-gray-400"></span>
          <input class="border-none bg-transparent outline-none text-sm w-full" placeholder="Search conversations..." />
        </div>
        <div class="flex gap-2" id="tabsContainer">
          <button onclick="setTab(this)" class="bg-blue-600 text-white border border-blue-600 rounded-full px-2.5 py-1 text-xs cursor-pointer transition-colors">All</button>
          <button onclick="setTab(this)" class="bg-transparent text-gray-500 border border-gray-200 rounded-full px-2.5 py-1 text-xs cursor-pointer hover:bg-gray-50 transition-colors">Unread</button>
          <button onclick="setTab(this)" class="bg-transparent text-gray-500 border border-gray-200 rounded-full px-2.5 py-1 text-xs cursor-pointer hover:bg-gray-50 transition-colors">Connections</button>
          <button onclick="setTab(this)" class="bg-transparent text-gray-500 border border-gray-200 rounded-full px-2.5 py-1 text-xs cursor-pointer hover:bg-gray-50 transition-colors">Groups</button>
        </div>
      </div>

      <!-- CONVO LIST -->
      <div class="flex-1 overflow-y-auto" id="convos"></div>

      <!-- NEW MESSAGE BTN -->
      <div class="p-4 border-t border-gray-200">
        <button class="w-full bg-blue-600 hover:bg-blue-700 text-white border-none rounded-lg py-2.5 text-sm font-semibold cursor-pointer transition-colors">
          + Start New Message
        </button>
      </div>
    </div>

    <!-- CHAT PANEL -->
    <div class="flex-1 flex flex-col">

      <!-- CHAT HEADER -->
      <div class="px-5 py-3 bg-white border-b border-gray-200 flex items-center gap-3">
        <div id="chatAvatar" class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">MR</div>
        <div>
          <div id="chatName" class="font-bold text-sm text-gray-900">Maria Rodriguez</div>
          <div class="text-xs text-green-500">Online</div>
        </div>
        <div class="ml-auto flex gap-4 text-xl text-gray-400 cursor-pointer">⋮ </div>
      </div>

      <!-- MESSAGES -->
      <div id="chatMessages" class="flex-1 overflow-y-auto p-5 flex flex-col gap-3 bg-gray-50"></div>
      
      <!-- INPUT -->
      <div class="bg-white border-t border-gray-200">
        <div class="flex items-center gap-3 px-4 py-3">
          <span class="text-xl cursor-pointer">📎</span>
          <input 
            id="msgInput"
            name="text"
            placeholder="Type your message..."
            onkeydown="if(event.key==='Enter') sendMsg()"
            class="flex-1 border border-gray-200 rounded-lg px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-blue-200"
          />
          <button onclick="sendMsg()" class="bg-transparent border-none text-2xl cursor-pointer text-blue-600">➤</button>
          
        </div>
        <div class="text-center text-xs text-gray-500 py-1.5 border-t border-gray-200">
           Your personal messages are secured
        </div>
      </div>
    </div>
  </div>

<script>
const convos = [
  { name: "Maria Rodriguez",  
    preview: "Thanks for the advice on internsh",
    time: "2:30 PM",    
    unread: 2, 
    color: "#3B82F6" },
];

const chatData = {
  0: [
    
  ]
};

let selectedConvo = 0;

function initials(name) 
    { return name.split(' ').map(n => n[0]).join('').slice(0, 2); }

function renderConvos() {
  document.getElementById('convos').innerHTML = convos.map((c, i) => `
    <div onclick="selectConvo(${i})"
      class="flex gap-3 px-4 py-3 border-b border-gray-200 cursor-pointer transition-colors ${i === selectedConvo ? 'bg-blue-50' : 'hover:bg-gray-50'}">
      <div class="w-10 h-10 rounded-full flex items-center justify-center text-white font-bold text-sm flex-shrink-0"
           style="background:${c.color}">${initials(c.name)}</div>
      <div class="flex-1 min-w-0">
        <div class="flex justify-between items-center">
          <span class="font-semibold text-sm text-gray-900">${c.name}</span>
          <span class="text-xs text-gray-400">${c.time}</span>
        </div>
        <div class="flex justify-between items-center mt-0.5">
          <span class="text-xs text-gray-500 overflow-hidden text-ellipsis whitespace-nowrap max-w-[160px]">${c.preview}</span>
          ${c.unread ? `<span class="bg-blue-600 text-white rounded-full text-xs px-1.5 py-0.5 font-bold leading-none">${c.unread}</span>` : ''}
        </div>
      </div>
    </div>
  `).join('');
}

function renderMessages() {
  const msgs = chatData[selectedConvo] || [];
  const el = document.getElementById('chatMessages');
  el.innerHTML = msgs.map(m => `
    <div class="max-w-[60%] ${m.from === 'me' ? 'self-end' : 'self-start'}">
      <div class="px-3.5 py-2.5 rounded-xl text-sm leading-relaxed
        ${m.from === 'me'
          ? 'bg-blue-600 text-white'
          : 'bg-white text-gray-900 border border-gray-200'}">
        ${m.text}
      </div>
      <div class="text-xs text-gray-400 mt-1 ${m.from === 'me' ? 'text-right' : 'text-left'}">${m.time}</div>
    </div>
  `).join('');
  el.scrollTop = el.scrollHeight;
}

function selectConvo(i) {
  selectedConvo = i;
  const c = convos[i];
  const avatar = document.getElementById('chatAvatar');
  avatar.textContent = initials(c.name);
  avatar.style.background = c.color;
  document.getElementById('chatName').textContent = c.name;
  renderConvos();
  renderMessages();
}

function sendMsg() {
    const input = document.getElementById('msgInput');
    const text = input.value.trim();

    if (text === "") return; // Don't send empty messages

    // 1. Prepare the data to send to PHP
    const formData = new FormData();
    formData.append('text', text);

    // 2. Send to PHP without reloading the page
    fetch('05-messages.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        console.log("Server response:", data);
    })
    .catch(error => console.error('Error:', error));

    // 3. Update the UI locally so it feels instant
    const now = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    
    // Add to your local chat array
    if (!chatData[selectedConvo]) chatData[selectedConvo] = [];
    chatData[selectedConvo].push({ from: 'me', text: text, time: now });

    // Clear input and refresh the message display
    input.value = '';
    renderMessages();
}

function setTab(btn) {
  document.querySelectorAll('#tabsContainer button').forEach(t => {
    t.className = 'bg-transparent text-gray-500 border border-gray-200 rounded-full px-2.5 py-1 text-xs cursor-pointer hover:bg-gray-50 transition-colors';
  });
  btn.className = 'bg-blue-600 text-white border border-blue-600 rounded-full px-2.5 py-1 text-xs cursor-pointer transition-colors';
}

renderConvos();
renderMessages();
</script>
</body>
</html>

