<?php
include("tools/userHeaderName.php"); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>UCA Connect – Connections</title>
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
        <a href="04-connections.php" class="flex items-center gap-2.5 px-6 py-2.5 text-sm font-semibold text-blue-600 bg-blue-50 border-r-4 border-blue-600 no-underline">Connections</a>
        <a href="05-messages.php"    class="flex items-center gap-2.5 px-6 py-2.5 text-sm text-gray-900 border-r-4 border-transparent hover:bg-gray-100 no-underline transition-colors">Messages</a>
        <a href="06-stories.php"     class="flex items-center gap-2.5 px-6 py-2.5 text-sm text-gray-900 border-r-4 border-transparent hover:bg-gray-100 no-underline transition-colors">Stories</a>
      </nav>
      <a href="settings.php" class="flex items-center gap-2.5 px-6 py-2.5 text-sm text-gray-500 no-underline">Profile &amp; Settings</a>
    </div>

    <!-- MAIN -->
    <div class="flex-1 p-8 overflow-y-auto">
      <h1 class="text-2xl font-bold text-gray-900 mb-6">Your Connections</h1>

      <!-- ACCEPTED -->
      <h2 class="text-base font-semibold text-gray-900 mb-4">Accepted Connections</h2>
      <div class="grid grid-cols-3 gap-4 mb-8">

        <div class="bg-white border border-gray-200 rounded-xl p-5">
          <div class="flex gap-3 items-center mb-3">
            <div class="w-12 h-12 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold text-base flex-shrink-0">JS</div>
            <div>
              <div class="font-semibold text-sm text-gray-900">Dr. John Smith</div>
              <div class="text-xs text-gray-500 mt-0.5">Head of AI Research at TechCorp</div>
            </div>
          </div>
          <div class="flex gap-2">
            <button class="flex-1 bg-white text-gray-900 border border-gray-200 rounded-lg py-2 text-xs cursor-pointer hover:bg-gray-50 transition-colors">View Profile</button>
            <button class="flex-1 bg-blue-600 hover:bg-blue-700 text-white border-none rounded-lg py-2 text-xs font-semibold cursor-pointer transition-colors">Message</button>
          </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl p-5">
          <div class="flex gap-3 items-center mb-3">
            <div class="w-12 h-12 rounded-full flex items-center justify-center text-white font-bold text-base flex-shrink-0" style="background:#10B981">SL</div>
            <div>
              <div class="font-semibold text-sm text-gray-900">Sarah Lee</div>
              <div class="text-xs text-gray-500 mt-0.5">Senior Product Manager at Innovate Inc.</div>
            </div>
          </div>
          <div class="flex gap-2">
            <button class="flex-1 bg-white text-gray-900 border border-gray-200 rounded-lg py-2 text-xs cursor-pointer hover:bg-gray-50 transition-colors">View Profile</button>
            <button class="flex-1 bg-blue-600 hover:bg-blue-700 text-white border-none rounded-lg py-2 text-xs font-semibold cursor-pointer transition-colors">Message</button>
          </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl p-5">
          <div class="flex gap-3 items-center mb-3">
            <div class="w-12 h-12 rounded-full flex items-center justify-center text-white font-bold text-base flex-shrink-0" style="background:#F59E0B">MC</div>
            <div>
              <div class="font-semibold text-sm text-gray-900">Michael Chen</div>
              <div class="text-xs text-gray-500 mt-0.5">Founder &amp; CEO of FutureLabs</div>
            </div>
          </div>
          <div class="flex gap-2">
            <button class="flex-1 bg-white text-gray-900 border border-gray-200 rounded-lg py-2 text-xs cursor-pointer hover:bg-gray-50 transition-colors">View Profile</button>
            <button class="flex-1 bg-blue-600 hover:bg-blue-700 text-white border-none rounded-lg py-2 text-xs font-semibold cursor-pointer transition-colors">Message</button>
          </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl p-5">
          <div class="flex gap-3 items-center mb-3">
            <div class="w-12 h-12 rounded-full flex items-center justify-center text-white font-bold text-base flex-shrink-0" style="background:#8B5CF6">ED</div>
            <div>
              <div class="font-semibold text-sm text-gray-900">Emily Davis</div>
              <div class="text-xs text-gray-500 mt-0.5">UX Lead at Creative Solutions</div>
            </div>
          </div>
          <div class="flex gap-2">
            <button class="flex-1 bg-white text-gray-900 border border-gray-200 rounded-lg py-2 text-xs cursor-pointer hover:bg-gray-50 transition-colors">View Profile</button>
            <button class="flex-1 bg-blue-600 hover:bg-blue-700 text-white border-none rounded-lg py-2 text-xs font-semibold cursor-pointer transition-colors">Message</button>
          </div>
        </div>

      </div>

      <!-- PENDING -->
      <h2 class="text-base font-semibold text-gray-900 mb-4">Pending Requests (Sent)</h2>
      <div class="grid grid-cols-3 gap-4 mb-8">

        <div class="bg-white border border-gray-200 rounded-xl p-5">
          <div class="flex gap-3 items-center mb-3">
            <div class="w-12 h-12 rounded-full flex items-center justify-center text-white font-bold text-base flex-shrink-0" style="background:#06B6D4">BC</div>
            <div>
              <div class="font-semibold text-sm text-gray-900">Dr. Ben Carter</div>
              <div class="text-xs text-gray-500 mt-0.5">Data Scientist at Global Analytics</div>
              <div class="text-xs text-gray-500 font-semibold mt-1">Pending</div>
            </div>
          </div>
          <div class="flex gap-2">
            <button class="flex-1 bg-white text-gray-900 border border-gray-200 rounded-lg py-2 text-xs cursor-pointer hover:bg-gray-50 transition-colors">View Profile</button>
            <button class="flex-1 bg-red-600 hover:bg-red-700 text-white border-none rounded-lg py-2 text-xs font-semibold cursor-pointer transition-colors">Retract Request</button>
          </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl p-5">
          <div class="flex gap-3 items-center mb-3">
            <div class="w-12 h-12 rounded-full flex items-center justify-center text-white font-bold text-base flex-shrink-0" style="background:#EC4899">JK</div>
            <div>
              <div class="font-semibold text-sm text-gray-900">Jessica Kim</div>
              <div class="text-xs text-gray-500 mt-0.5">Marketing Specialist at BrandBoost</div>
              <div class="text-xs text-gray-500 font-semibold mt-1">Pending</div>
            </div>
          </div>
          <div class="flex gap-2">
            <button class="flex-1 bg-white text-gray-900 border border-gray-200 rounded-lg py-2 text-xs cursor-pointer hover:bg-gray-50 transition-colors">View Profile</button>
            <button class="flex-1 bg-red-600 hover:bg-red-700 text-white border-none rounded-lg py-2 text-xs font-semibold cursor-pointer transition-colors">Retract Request</button>
          </div>
        </div>

      </div>

      <!-- DECLINED -->
      <h2 class="text-base font-semibold text-gray-900 mb-4">Declined Requests</h2>
      <div class="grid grid-cols-3 gap-4">

        <div class="bg-white border border-gray-200 rounded-xl p-5">
          <div class="flex gap-3 items-center mb-3">
            <div class="w-12 h-12 rounded-full flex items-center justify-center text-white font-bold text-base flex-shrink-0" style="background:#6366F1">DR</div>
            <div>
              <div class="font-semibold text-sm text-gray-900">David Rodriguez</div>
              <div class="text-xs text-gray-500 mt-0.5">Financial Analyst at Capital Group</div>
              <span class="inline-block mt-1 bg-red-100 text-red-600 text-xs font-semibold px-2 py-0.5 rounded">Declined</span>
            </div>
          </div>
          <div class="flex gap-2">
            <button class="flex-1 bg-white text-gray-900 border border-gray-200 rounded-lg py-2 text-xs cursor-pointer hover:bg-gray-50 transition-colors">View Profile</button>
            <button class="flex-1 bg-white text-gray-900 border border-gray-200 rounded-lg py-2 text-xs cursor-pointer hover:bg-gray-50 transition-colors">Dismiss</button>
          </div>
        </div>

      </div>
    </div>
  </div>

  <!-- FOOTER -->
  <?php 
  include("tools/footer.php");
  ?>

</body>
</html>