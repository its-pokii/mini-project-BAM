<?php 
include("C:/xampp/htdocs/alumni-project/our_project/includes/headers/free-header.php");
include("C:/xampp/htdocs/alumni-project/our_project/includes/script-var.php")
?>

    <body class="bg-[#f8fafc] box-border p-0 m-0 font-['Roboto']">
        <main>
            <div class="min-h-[500px] px-4 py-12 bg-light-bg flex justify-center items-center">
                <div class="connect-container w-[800px] text-center flex flex-col justify-center items-center">
                    <div class="welcome-text">
                        <h1 class="text-primary text-[50px] mx-auto mb-[5px]">Connect with UCA Alumni</h1>
                    </div>
                    <div class="desc-txt">
                        <p class="text-muted">Forge meaningful connections, discover inspiring sucess stories, and contribute to a vibrant university community
                        </p>
                    </div>
                    <div class="flex gap-[1em]">
                        <a href="login.php" class="no-underline bg-primary text-white border border-[#edf8fb] px-8 py-2.5 rounded-lg font-semibold hover:bg-blue-400 inline-block">Login</a>
                        <a href="register.php" class="no-underline bg-white text-black border border-[#edf8fb] px-8 py-2.5 rounded-lg font-semibold hover:bg-gray-200 inline-block">Register</a>
                    </div>
                </div>
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                <h2 class="text-3xl font-bold text-center mb-12">How It Works</h2>
                
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="text-center">
                        <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i data-lucide="users" class="w-8 h-8 text-blue-600"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Find Alumni</h3>
                        <p class="text-gray-600">
                            Search and connect with alumni from your field of study working at top companies worldwide
                        </p>
                    </div>

                    <div class="text-center">
                        <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i data-lucide="message-circle" class="w-8 h-8 text-blue-600"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Get Mentorship</h3>
                        <p class="text-gray-600">
                            Message alumni directly for career advice, interview tips, and industry insights
                        </p>
                    </div>

                    <div class="text-center">
                        <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i data-lucide="book-open" class="w-8 h-8 text-blue-600"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Read Success Stories</h3>
                        <p class="text-gray-600">
                            Get inspired by career journeys and learn from the experiences of successful alumni
                        </p>
                    </div>
                </div>
            </div>

            <div class="gateway bg-light-bg h-[400px] flex justify-center items-center border-b border-[rgb(210,211,211)]">
                <div class="w-[800px] text-center flex flex-col justify-center items-center">
                    <div class="gateway-txt text-[22px]">
                        <h2 class="text-primary">Your Gateway to a Thriving UCA Network</h2>
                    </div>
                    <div class="text-muted">
                        <p>
                            UCA Connect bridges the gap between past and present, offering students unparalleled access to
                            mentorship and career insights from successful alumni. Alumni can give back by mentoring the next generation, 
                            sharing their professional journeys, and rediscovering old connections.
                        </p>
                        <p>
                            Whether you're looking for guidance, aiming to share your expertise, or simply want to stay in touch with UCA community, 
                            our platform provides the tools and connections you need to succeed.
                        </p>
                    </div>
                </div>
            </div>
            <style>
                .animated-button svg { position: absolute; width: 24px; fill: #228cef; z-index: 9; transition: all 0.8s cubic-bezier(0.23, 1, 0.32, 1); }
                .animated-button .arr-1 { right: 16px; }
                .animated-button .arr-2 { left: -25%; }
                .animated-button .circle { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 20px; height: 20px; background-color: #228cef; border-radius: 50%; opacity: 0; transition: all 0.8s cubic-bezier(0.23, 1, 0.32, 1); }
                .animated-button .text { position: relative; z-index: 1; transform: translateX(-12px); transition: all 0.8s cubic-bezier(0.23, 1, 0.32, 1); }
                .animated-button:hover .arr-1 { right: -25%; }
                .animated-button:hover .arr-2 { left: 16px; }
                .animated-button:hover .text { transform: translateX(12px); }
                .animated-button:hover svg { fill: #212121; }
                .animated-button:hover .circle { width: 220px; height: 220px; opacity: 1; }
            </style>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
                <h2 class="text-3xl font-bold mb-4">Ready to Get Started?</h2>
                <p class="text-gray-600 mb-8">Join the UCA Alumni Network today</p>
                <a href="register.php" class="m-auto w-[150px] animated-button relative flex items-center gap-1 px-9 py-4 border-4 border-transparent text-base font-semibold text-primary shadow-[0_0_0_2px_#228cef] rounded-full overflow-hidden cursor-pointer hover:shadow-[0_0_0_12px_transparent] hover:text-[#212121] hover:rounded-xl active:scale-95 active:shadow-[0_0_0_4px_#228cef] transition-all duration-700 no-underline">
                    <svg viewBox="0 0 24 24" class="arr-2" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z"></path>
                    </svg>
                    <span class="text">Get Started</span>
                    <span class="circle"></span>
                    <svg viewBox="0 0 24 24" class="arr-1" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z"></path>
                    </svg>
                </a>
            </div>
        </main>
        <?php 
        include("C:/xampp/htdocs/alumni-project/our_project/includes/footer.php");
        ?>
    </body>

    <script>
        lucide.createIcons();
    </script>
</html>