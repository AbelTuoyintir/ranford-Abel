@auth
<x-admin-sidebar>

    <div class="bg-gray-50">
        <!-- Header -->
        <header class="bg-blue-700 text-white">
          <div class="container mx-auto px-4 py-10">
            <h1 class="text-4xl font-bold mb-2">OVERVIEW</h1>
            <p class="text-xl">Traditional vs. Digital Approaches</p>
          </div>
        </header>
      
        <!-- Main Content -->
        <main class="container mx-auto px-4 py-8">
          <!-- Introduction -->
          <section class="mb-12">
            <p class="text-lg text-gray-700 mb-4">
                Voting systems are evolving rapidly with technology, and the UCC Voting System exemplifies this evolution by integrating both traditional offline methods and modern online solutions.
            </p>
          </section>
      
          <!-- Two-column layout for desktop -->
          <div class="grid md:grid-cols-2 gap-8 mb-12">
            <!-- Traditional Voting -->
            <section class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="bg-blue-600 text-white p-4">
                  <h2 class="text-2xl font-bold">UCC Offline Voting System</h2>
                </div>
                <div class="p-6">
                  <h3 class="text-xl font-semibold mb-3">How It Works</h3>
                  <p class="mb-4">
                    Voters arrive at the designated polling station with their student ID, where a voting machine is already set up. A verification officer, responsible for confirming voting status, initiates the process by sending an email to the voter. The voter then clicks the confirmation button in the email to change their status from unverified to verified and receive a random password.
                  </p>
                  <p class="mb-4">
                    If network issues occur, the officer uses an alternative verification portal. Here, the voter provides their date of birth; if it matches the records, their status is updated to verified and their password is set to their date of birth. Once verified, the voter logs into the voting machine using the provided password.
                  </p>
                  <p class="mb-4">
                    Upon logging in, the voter can access the general poll. Access to department or hall-specific polls is restricted to those who belong to the respective groups. The voter can preview their selections before submitting their vote. After submission, the voter is logged out and may receive a confirmation email, depending on the poll settings.
                  </p>
              
                  <h3 class="text-xl font-semibold mb-3">Oversight and Monitoring</h3>
                  <p class="mb-4">
                    The system features a secure strongroom where authorized personnel monitor the entire process through a dedicated account. In addition, verification officers or designated officials in the voting room have access to a real-time dashboard that shows overall voting status while protecting individual vote details.
                  </p>
              
                  <h3 class="text-xl font-semibold mb-3">Advantages</h3>
                  <ul class="list-disc pl-5 mb-4 space-y-2">
                    <li><span class="font-medium">Robust Verification:</span> Dual verification methods via email and alternative portal ensure accurate voter authentication.</li>
                    <li><span class="font-medium">Secure Access:</span> Restricted viewing of department/hall polls maintains the integrity of targeted votes.</li>
                    <li><span class="font-medium">Real-Time Oversight:</span> Continuous monitoring by authorized personnel enhances transparency and security.</li>
                    <li><span class="font-medium">Resilience Against Network Issues:</span> The fallback verification portal minimizes disruptions during network outages.</li>
                  </ul>
              
                  <h3 class="text-xl font-semibold mb-3">Challenges</h3>
                  <ul class="list-disc pl-5 space-y-2">
                    <li><span class="font-medium">Dependence on Email Verification:</span> Timely delivery and user action on verification emails is critical.</li>
                    <li><span class="font-medium">Potential Network Vulnerabilities:</span> Network issues could disrupt email-based verification, though alternative methods are available.</li>
                    <li><span class="font-medium">Complex Oversight Requirements:</span> Managing access for strongroom monitors and public verification requires robust security protocols.</li>
                    <li><span class="font-medium">User Navigation:</span> The multi-step verification process may pose challenges for some voters.</li>
                  </ul>
                </div>
              </section>
              
      
            <!-- Online Voting -->
            <section class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="bg-green-600 text-white p-4">
                  <h2 class="text-2xl font-bold">UCC Online Voting System</h2>
                </div>
                <div class="p-6">
                  <h3 class="text-xl font-semibold mb-3">How It Works</h3>
                  <p class="mb-4">
                    The online voting process is initiated by the admin, who sends verification emails to all registered voters via an automatic verification page. Each email contains a unique random password along with a verification link.
                  </p>
                  <p class="mb-4">
                    Voters verify their status by clicking the link in the email. If the link expires within 24 hours, or if a voter does not receive the email, the admin can use the manual verification process to resend verification to that specific user.
                  </p>
                  <p class="mb-4">
                    An alternative verification method uses Google verification. In this process, the system checks if the user is in the database. If confirmed, the voter is assigned a default password of their date of birth and redirected to a feedback page. The voter is then advised to log in using this default password and change it immediately for security.
                  </p>
                  <p class="mb-4">
                    Once verified—whether through the email method with a random password or via Google verification—the voter can log in from anywhere and proceed to vote.
                  </p>
              
                  <h3 class="text-xl font-semibold mb-3">Oversight and Monitoring</h3>
                  <p class="mb-4">
                    In the online system, oversight is fully automated. Each hall maintains its own "strongroom" dashboard to monitor the ongoing voting process within that hall. Meanwhile, the SRC has access to a "super strongroom" dashboard that displays comprehensive data on all candidates and overall voting trends, including who is winning. In this process, there is no role for a verification officer.
                  </p>
              
                  <h3 class="text-xl font-semibold mb-3">Advantages</h3>
                  <ul class="list-disc pl-5 mb-4 space-y-2">
                    <li><span class="font-medium">Wide Accessibility:</span> Voters can log in and vote from any location with internet access.</li>
                    <li><span class="font-medium">Automated Verification:</span> An automatic email system streamlines voter authentication.</li>
                    <li><span class="font-medium">Fallback Options:</span> Manual and Google verification methods ensure all voters are verified even if the initial email link fails.</li>
                    <li><span class="font-medium">Prompt Feedback:</span> Voters are directed to a feedback page after verification for swift issue resolution.</li>
                    <li><span class="font-medium">Real-Time Monitoring:</span> Dedicated strongroom dashboards for halls and a super strongroom for the SRC enable transparent, comprehensive oversight.</li>
                  </ul>
              
                  <h3 class="text-xl font-semibold mb-3">Challenges</h3>
                  <ul class="list-disc pl-5 space-y-2">
                    <li><span class="font-medium">Email Expiration:</span> Verification links expire after 24 hours, requiring alternative verification for delayed responses.</li>
                    <li><span class="font-medium">Internet Dependence:</span> Reliable internet connectivity is essential, which may be a limitation in some areas.</li>
                    <li><span class="font-medium">Default Password Risks:</span> Users verified via Google receive a default password (date of birth)  and must change it immediately to maintain security.</li>
                    <li><span class="font-medium">Process Complexity:</span> Managing multiple verification methods increases system complexity and requires robust monitoring.</li>
                  </ul>
                </div>
              </section>
              
              
          </div>
      
          <!-- admin Approaches -->
          <section class="bg-white rounded-lg shadow-lg overflow-hidden mb-12">
            <div class="bg-purple-600 text-white p-4">
              <h2 class="text-2xl font-bold">Admin Features and Operations</h2>
            </div>
            <div class="p-6">
              <p class="mb-4">
                The admin panel is the central hub for managing the UCC Voting System. It enables administrators to control and streamline the online voting process without the need to fetch all data directly from the database.
              </p>
              <div class="grid md:grid-cols-2 gap-4">
                <div class="bg-purple-50 p-4 rounded-lg">
                  <h3 class="font-semibold text-purple-700 mb-2">Automated & Manual Verification</h3>
                  <p>
                    Admins can direct users to the verification route at <code>127.0.0.1:800/google-verification</code>. This route checks if a user is in the database via Google verification, assigns a default password (date of birth), and sends them to a feedback page. If necessary, manual verification can be initiated for specific users.
                  </p>
                </div>
                <div class="bg-purple-50 p-4 rounded-lg">
                  <h3 class="font-semibold text-purple-700 mb-2">Voter Login Portal</h3>
                  <p>
                    Voters can access the voting system using <code>127.0.0.1:800/student-login</code>, enabling them to vote securely from any location.
                  </p>
                </div>
                <div class="bg-purple-50 p-4 rounded-lg">
                  <h3 class="font-semibold text-purple-700 mb-2">Admin Dashboard</h3>
                  <p>
                    Verification officers or moderators use the main login page at <code>127.0.0.1:800/</code> to access the admin dashboard. This portal provides live monitoring, detailed logs, and an overview of the voting process without exposing full database details.
                  </p>
                </div>
                <div class="bg-purple-50 p-4 rounded-lg">
                  <h3 class="font-semibold text-purple-700 mb-2">Member & Candidate Management</h3>
                  <p>
                    Through the "Manage Members" feature, admins can add candidates and other members, create polls, and assign candidates to polls. Admins must first ensure that portfolios are created on the portfolio page so that they can be properly added to the respective polls.
                  </p>
                </div>
                <div class="bg-purple-50 p-4 rounded-lg">
                  <h3 class="font-semibold text-purple-700 mb-2">Activity Logs & Monitoring</h3>
                  <p>
                    The admin has full access to comprehensive logs and details, enabling them to monitor system activity, track voter engagement, and ensure overall process integrity.
                  </p>
                </div>
              </div>
            </div>
          </section>
          
      
          <!-- Implementation Considerations -->
          <section class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="bg-gray-700 text-white p-4">
              <h2 class="text-2xl font-bold">Considerations for Implementation</h2>
            </div>
            <div class="p-6">
              <p class="mb-4">
                Any voting system must balance multiple critical factors:
              </p>
              <div class="grid grid-cols-5 md:grid-cols-5 gap-4 text-center">
                <div class="bg-gray-100 p-4 rounded-lg flex flex-col items-center">
                  <div class="bg-gray-700 text-white rounded-full w-16 h-16 flex items-center justify-center mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                  </div>
                  <h3 class="font-semibold">Security</h3>
                  <p class="text-sm">Protection against fraud and tampering</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg flex flex-col items-center">
                  <div class="bg-gray-700 text-white rounded-full w-16 h-16 flex items-center justify-center mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                  </div>
                  <h3 class="font-semibold">Accessibility</h3>
                  <p class="text-sm">Equal opportunity for all eligible voters</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg flex flex-col items-center">
                  <div class="bg-gray-700 text-white rounded-full w-16 h-16 flex items-center justify-center mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                    </svg>
                  </div>
                  <h3 class="font-semibold">Transparency</h3>
                  <p class="text-sm">Clear processes that build public trust</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg flex flex-col items-center">
                  <div class="bg-gray-700 text-white rounded-full w-16 h-16 flex items-center justify-center mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                  </div>
                  <h3 class="font-semibold">Accuracy</h3>
                  <p class="text-sm">Reliable recording and counting of votes</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg flex flex-col items-center">
                  <div class="bg-gray-700 text-white rounded-full w-16 h-16 flex items-center justify-center mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                  </div>
                  <h3 class="font-semibold">Privacy</h3>
                  <p class="text-sm">Protection of voter identity and choices</p>
                </div>
              </div>
            </div>
          </section>
        </main>
      
        <!-- Footer -->
        <footer class="bg-gray-800 text-white py-8">
          <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
              <div class="mb-4 md:mb-0">
                <h2 class="text-xl font-bold">Voting Systems Overview</h2>
                <p class="text-gray-400">Comparing traditional and digital approaches</p>
              </div>
              <div>
                <p class="text-gray-400">&copy; 2025 Election Information Center</p>
              </div>
            </div>
          </div>
        </footer>
    </div>


</x-admin-sidebar>
@else
<script>
	window.location.href = "{{ route('/student') }}";
</script>
@endauth