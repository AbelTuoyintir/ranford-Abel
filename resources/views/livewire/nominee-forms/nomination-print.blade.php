@auth('ticket')
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>UCC SRC/Local NUGS Elections Nomination Form</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="icon" href="/images/logo60.jpg" type="image/x-icon" class=" rounded-full w-16 h-16">
  @vite(["resources/css/app.css", "resources/js/app.js"])
  <style>
    @media print {
      body * {
        visibility: hidden;
      }
      #printableForm, #printableForm * {
        visibility: visible;
      }
      #printableForm {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        padding: 20px;
        background: white;
      }
      .no-print {
        display: none !important;
      }
    }
    .form-line {
      display: flex;
      margin-bottom: 15px;
    }
    .form-label {
      width: 200px;
      font-weight: 500;
    }
    .form-input {
      flex: 1;
      border-bottom: 1px solid #000;
      min-height: 20px;
    }
    .signature-line {
      width: 150px;
      border-bottom: 1px solid #000;
      display: inline-block;
      margin-right: 20px;
    }
    .declaration-box {
      border: 1px solid #000;
      padding: 15px;
      margin-top: 20px;
    }
  </style>
</head>
<body class="bg-gray-100 p-4">
  <!-- Main Form -->
  <div class="container">

    @if(session('success'))
        <div class="fixed top-4 left-4 z-50 success-prompt" role="alert">
            <div class="bg-green-500 text-white px-6 py-4 rounded-lg shadow-xl transition-transform duration-300 ease-in-out animate-bounce">
                <div class="flex items-center">
                    <svg class="w-6 h-6 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        </div>
    @endif

  <!-- Printable Form (hidden by default) -->
  <div id="printableForm" class="max-w-4xl mx-auto bg-white p-6">
    <div class="text-center font-bold text-lg mb-4"><span class="currentAcademicYear"></span>  <span id="printFormTitle">SRC/LOCAL NUGS ELECTIONS NOMINATION FORM</span></div>
    
    <div class="mb-6">
      <div class="font-semibold mb-2">INSTRUCTIONS</div>
      <p class="text-sm mb-4">
        Please, write your full name clearly against the post for which you wish to contest and provide the requested information. Falsification of any information leads to automatic disqualification. 
        <strong>Note that Voucher expires 30th May, 2025</strong>
      </p>
    </div>
            {{ $user->position }}
        {{-- @foreach ($user as $as_user)
            {{ $as_user->position }}
        @endforeach --}}

        {{-- @foreach ($supporters as $as_supporters)
            {{ $as_supporters->name }}
        @endforeach --}}
    <!-- Dynamic Portfolio Sections -->
    <div id="srcPortfolioSection">
        
      <div class="form-line">
        <div class="form-label">{{ $user->position }}:</div>
        <div class="form-input" id="printPresident">{{ $user->full_name }}</div>
      </div>
      @if ($user->running_mate)
      <div class="form-line">
        <div class="form-label">Running Mate:</div>
        <div class="form-input" id="printRunningMate">{{ $user->running_mates_full_name }}</div>
      </div>
      @endif
    </div>

    <div class="flex mt-6 ">
      <div class="w-1/2 pr-4">
        <div class="form-line">
          <div class="form-label">Hall of affiliation:</div>
          <div class="form-input" id="printHall">{{ $user->hall }}</div>
        </div>
        <div class="form-line">
          <div class="form-label">Programme of Study:</div>
          <div class="form-input" id="printProgram">{{ $user->program }}</div>
        </div>
        <div class="form-line">
          <div class="form-label">Registration No:</div>
          <div class="form-input" id="printRegNumber">{{ $user->reg_number }}</div>
        </div>
        <div class="form-line">
          <div class="form-label">Phone Number:</div>
          <div class="form-input" id="printPhone">{{ $user->phone }}</div>
        </div>
        <div class="form-line">
          <div class="form-label">Signature:</div>
          <div class="signature-line"></div>
          <div class="form-label">Date:</div>
          <div class="signature-line"></div>
        </div>
      </div>
      @if ($user->running_mate)
      <div class="w-1/2 pl-4">
        <div id="runningMatePrintSection">
            {{-- <h4>For Running Mates Only</h4> --}}
          <div class="form-line">
            <div class="form-label">For Running Mates Only</div>
            {{-- <div class="form-input">{{ $user->running_mates_hall }}</div> --}}
          </div>
          <div class="form-line">
            <div class="form-label">Programme of Study:</div>
            <div class="form-input" id="printMateProgram">{{ $user->running_mates_program }}</div>
          </div>
          <div class="form-line">
            <div class="form-label">Registration No:</div>
            <div class="form-input" id="printMateRegNumber">{{ $user->running_mates_reg_number }}</div>
          </div>
          <div class="form-line">
            <div class="form-label">Phone Number:</div>
            <div class="form-input" id="printMatePhone">{{ $user->running_mates_phone }}</div>
          </div>
          <div class="form-line">
            <div class="form-label">Signature:</div>
            <div class="signature-line"></div>
            <div class="form-label">Date:</div>
            <div class="signature-line"></div>
          </div>
        </div>
      </div>
      @endif
    </div>
   
    <div class="mt-2">
      <p>This nomination is supported by (Name and Address of two (2) persons)</p>
      @foreach ($supporters as $as_supporters)
        <div class="mt-4">
            <div class="form-line">
            <div class="form-label">{{ $loop->iteration }}. Name:</div>
            <div class="form-input" id="printSupporter1Name">{{ $as_supporters->name }}</div>
            </div>
            <div class="form-line">
            <div class="form-label">Hall of Affiliation:</div>
            <div class="form-input" id="printSupporter1Hall">{{ $as_supporters->hall }}</div>
            <div class="form-label">Department:</div>
            <div class="form-input" id="printSupporter1Dept">{{ $as_supporters->department }}</div>
            </div>
            <div class="form-line">
            <div class="form-label">Programme of Study:</div>
            <div class="form-input" id="printSupporter1Program">{{ $as_supporters->program }}</div>
            <div class="form-label">Reg.No:</div>
            <div class="form-input" id="printSupporter1Reg">{{ $as_supporters->reg_number }}</div>
            </div>
            <div class="form-line">
            <div class="form-label">Phone Number:</div>
            <div class="form-input" id="printSupporter1Phone">{{ $as_supporters->phone }}</div>
            </div>
            <div class="form-line">
            <div class="form-label">Signature:</div>
            <div class="signature-line"></div>
            <div class="form-label">Date:</div>
            <div class="form-input" id="printSupporter1Date">{{ $as_supporters->created_at->format('Y-m-d') }}</div>
            </div>
        </div>
        @endforeach
    </div>

    <p class="mt-4"><strong>NB:</strong> All aspirants must attach photocopies of the I.D.'s of their nominees and they must be students in good standing before they can endorse them.</p>
    
    <div class="mt-8">
      <div class="font-semibold">FOR OFFICE USE</div>
      <div class="form-line">
        <div class="form-label">Date submitted:</div>
        <div class="form-input"></div>
      </div>
      <div class="form-line">
        <div class="form-label">Approved [ ]</div>
        <div class="form-label">Not Approved [ ]</div>
      </div>
      <div class="form-line">
        <div class="form-label">Reason(s):</div>
        <div class="form-input"></div>
      </div>
      <div class="form-line">
        <div class="form-label">Signature (Chairman-Electoral Commission):</div>
        <div class="signature-line"></div>
        <div class="form-label">Date:</div>
        <div class="signature-line"></div>
      </div>
    </div>

    <!-- Declaration Form -->
    <div class="mt-2" style="page-break-before: always;">
      <div class="text-center font-bold mb-4">UNIVERSITY OF CAPE COAST</div>
      <div class="text-center font-bold mb-4">OFFICE OF THE DEAN OF STUDENTS</div>
      <div class="font-semibold text-center mb-4">DECLARATION TO ABIDE BY UCC REGULATIONS ON THE CONDUCT OF  <span class="currentAcademicYear"> </span> ELECTIONS</div>
      
      <div class="declaration-box">
        <p>I, <span class="form-input inline-block w-64" id="printDeclareName">{{ $user->full_name }}</span>,</p>
        <p>an aspirant in the  SRC/L.NUGS/GRASAG/ICRC elections, for the position of <span class="form-input inline-block w-64" id="printDeclarePortfolio">{{ $user->position }}</span></p>
        <p>do hereby pledge to abide by all rules and regulations governing elections and students conduct on UCC campus during the electioneering and voting period, and that should I or any of my polling agents/supporters do contrary, I be disqualified from the said elections.</p>
        
        <div class="mt-8">
          <div class="form-line">
            <div class="form-label">Name:</div>
            <div class="form-input" id="printDeclareName2">{{ $user->full_name }}</div>
          </div>
          <div class="form-line">
            <div class="form-label">Registration Number:</div>
            <div class="form-input" id="printDeclareReg">{{ $user->reg_number }}</div>
          </div>
          <div class="form-line">
            <div class="form-label">Signature:</div>
            <div class="signature-line"></div>
          </div>
        </div>
      </div>
    </div>

    <!-- Instructions -->
    <div class="mt-2" style="page-break-before: always;">
      <div class="font-semibold ">INSTRUCTIONS FOR SUBMISSION OF NOMINATION FORM</div>
      <p>You are to provide the following when submitting your nomination form to the Office of the Dean of Students:</p>
      
      <ol class="list-decimal pl-5 mt-4 space-y-2">
        <li>The original copy of the nomination form with thirteen (13) photocopies</li>
        <li>Evidence of your most recent CGPA (for medical students, evidence of academic records)</li>
        <li>Receipt of fees paid for the recent academic year</li>
        <li>Curriculum Vitae (All aspirants are expected to provide details (phone contact and e-mail address) of 2 referees (One of whom must be a Lecturer/Head of an Institution)</li>
        <li>Current medical report (from the University Hospital)</li>
        <li>Soft copy of your picture (in JPEG format) to be used throughout the election process (if you pass) to be sent via email students.affairs@ucc.edu.gh<br>
        Indicate your name, teaser and portfolio in the mail.</li>
        <li>Signed declaration form (see attached)</li>
      </ol>
    </div>

    <div class="no-print mt-8 text-center">
      <button onclick="window.print()" class="bg-blue-600 text-white px-6 py-2 rounded-md mr-4">Print Form</button>
    <button onclick="closePrintView()" class="bg-gray-600 text-white px-6 py-2 rounded-md">Close</button>
    <script>
      function closePrintView() {
        window.history.back();
      }
    </script>
    </div>
  </div>

  
</body>
</html>
@else
<script>
	window.location.href = "{{ route('/normination-landing-page') }}";
</script>
@endauth