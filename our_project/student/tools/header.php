

<header>
<div class="h-14 bg-white border-b border-gray-200 flex items-center justify-between px-6 flex-shrink-0">
    <div class="flex items-center gap-2 font-bold text-lg text-blue-600">
      UCA Connect
    </div>
    <div class="flex-1 max-w-sm mx-6 flex items-center bg-gray-50 border border-gray-200 rounded-lg px-3 py-1.5 gap-2">
      <span class="text-gray-400">🔍</span>
      <input class="border-none bg-transparent outline-none text-sm w-full" placeholder="Search..." />
    </div>
    <div class="flex items-center gap-4">
      <div class="flex items-center gap-2">
        <img 
          src="images\1379888206.jpg" 
          alt="Profile" 
          class="w-9 h-9 rounded-full object-cover border border-gray-200"
        />
        <span class="text-sm font-medium text-gray-700">Hello, <span class="font-semibold text-blue-600"><?= htmlspecialchars($user['first_name'])?></span></span>
      </div>
    </div>
  </div>
  </header>