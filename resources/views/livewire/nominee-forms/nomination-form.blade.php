@auth('ticket')
@php
  $runningMateDraft = $draftNominee?->runningMate;
  $supportersDraft = $draftNominee?->supporters ?? collect();
  $supporterOneDraft = $supportersDraft->get(0);
  $supporterTwoDraft = $supportersDraft->get(1);
@endphp
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
    @if ($errors->any())
        <div class="fixed top-4 right-4 z-50 error-prompt" role="alert">
            <div class="bg-red-500 text-white px-6 py-4 rounded-lg shadow-xl transition-transform duration-300 ease-in-out animate-bounce">
                <div class="flex items-center">
                    <svg class="w-6 h-6 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 12H6"></path>
                    </svg>
                    <ul class="list-disc ml-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

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

    <script>
        // Auto-dismiss for success prompt
        setTimeout(() => {
            const successMessage = document.querySelector('.success-prompt');
            if (successMessage) {
                successMessage.classList.add('opacity-0', 'transform', 'translate-x-full');
                setTimeout(() => {
                    successMessage.remove();
                }, 500);
            }
        }, 5000);

        // Auto-dismiss for error prompt
        setTimeout(() => {
            const errorMessage = document.querySelector('.error-prompt');
            if (errorMessage) {
                errorMessage.classList.add('opacity-0', 'transform', 'translate-x-full');
                setTimeout(() => {
                    errorMessage.remove();
                }, 500);
            }
        }, 5000);
    </script>
  </div>

  <div class="max-w-4xl mx-auto bg-white p-6 shadow-md no-print">
    <div class="flex justify-between items-center mb-8">
      <img src="{{ asset('images/ucc.png') }}" alt="UCC Logo" class="h-16">
      <div class="text-right">
          <h1 class="text-2xl font-bold text-blue-800">UCC-EVOTE</h1>
          <p class="text-sm text-gray-600">UCC Nomination Form</p>
      </div>
    </div>

    <div class="mb-6">
      <h2 class="text-lg font-semibold mb-2">INSTRUCTIONS</h2>
      <p class="text-sm">
        Please, write your full name clearly against the post for which you wish to contest and provide the requested information. Falsification of any information leads to automatic disqualification. 
        <strong>Vouchers are valid for 5 days from the date of acquisition. After this period, the voucher will automatically expire and cannot be used.</strong>
        <strong><h3 class="text-red-500">NB: NOTE ALL REGISTRATION NUMBERS SHOULD BE CAPITAL LETTERS</n3></strong>
        <strong><h3 class="text-red-500">NB: PLEASE PRINT THE FORM BEFORE YOU SUBMIT. THE FORM WILL NOT BE AVAIABLE FOR PRINTING AFTER SUBMISSION</n3></strong>

      </p>
    </div>

    <form id="nominationForm" class="space-y-4" method="POST" action="{{ route('nominee.store') }}">
      @csrf
      <input type="hidden" id="nominee_cgpa" name="nominee_cgpa" value="">
      <input type="hidden" id="running_mates_cgpa" name="running_mates_cgpa" value="">
      <input type="hidden" id="running_mates_full_name" name="running_mates_full_name" value="">
      <input type="hidden" id="running_mates_hall" name="running_mates_hall" value="">
      
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Portfolio:</label>
        <select name="position" id="portfolio" class="w-full p-2 border border-gray-300 rounded-md" required>
          <option value="">Select Portfolio</option>
          <optgroup label="SRC Positions">
            <option value="SRC President">SRC President</option>
            <option value="SRC Secretary">SRC Secretary</option>
            <option value="SRC Treasurer">SRC Treasurer</option>
            <option value="SRC General Sports Secretary">SRC General Sports Secretary</option>
            <option value="SRC Coordinating Secretary">SRC Coordinating Secretary</option>
            <option value="SRC Public Relations Officer">SRC Public Relations Officer</option>
            <option value="SRC Women's Commissioner">SRC Women's Commissioner</option>
          </optgroup>

          <optgroup label="Local NUGS Positions">
            <option value="Local NUGS President">Local NUGS President</option>
            <option value="Local NUGS Secretary">Local NUGS Secretary</option>
          </optgroup>

          <optgroup label="JCRC Positions">
            <option value="JCRC President">JCRC President</option>
            <option value="JCRC Secretary">JCRC Secretary</option>
            <option value="JCRC Treasurer">JCRC Treasurer</option>
            <option value="JCRC Welfare Chairperson">JCRC Welfare Chairperson</option>
            <option value="JCRC Sport Secretary">JCRC Sport Secretary</option>
            <option value="JCRC Library Chairperson">JCRC Library Chairperson</option>
            <option value="JCRC SRC Representative(s)">JCRC SRC Representative(s)</option>
          </optgroup>

          <optgroup label="GRASAG Positions">
            <option value="GRASAG President">GRASAG President</option>
            <option value="GRASAG Secretary">GRASAG Secretary</option>
            <option value="GRASAG Treasurer">GRASAG Treasurer</option>
            <option value="GRASAG Financial Secretary">GRASAG Financial Secretary</option>
            <option value="GRASAG Organising Secretary">GRASAG Organising Secretary</option>
            <option value="GRASAG Women's Commissioner">GRASAG Women's Commissioner</option>
          </optgroup>
        </select>
      </div>

      <div class="space-y-3">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Registration No:</label>
          <input name="reg_number" value="{{ old('reg_number') }} " type="text" id="regNumber" class="w-full p-2 border border-gray-300 rounded-md" oninput="searchUser(event)"  />
          <div id="searchResults" class="mt-2"></div>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Full Name:</label>
            <input readonly name="full_name" type="text" id="fullName" class="w-full p-2 border border-gray-300 rounded-md" value="{{ old('full_name') }}" />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Hall of Affiliation:</label>
          <input readonly  name="hall" value="{{ old('hall') }} " type="text" id="hall" class="w-full p-2 border border-gray-300 rounded-md" required />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Programme of Study:</label>
          <input readonly name="program" value="{{ old('program') }} "  type="text" id="program" class="w-full p-2 border border-gray-300 rounded-md" required />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number:</label>
          <input readonly  name="phone" value="{{ old('phone') }} " type="tel" id="phone" class="w-full p-2 border border-gray-300 rounded-md" required />
        </div>

        <div>
          <label class="inline-flex items-center">
            <input name="verified" type="checkbox"   class="mr-2" />
            I hereby confirm that the information provided above is true and correct.
          </label>
        </div>
      </div>

      <div id="runningMateSection" class="space-y-3 hidden">
        <h3 class="text-lg font-semibold mb-2">For Running Mates Only</h3>
        
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Registration No:</label>
          <input name="running_mates_reg_number" value="{{ old('running_mates_reg_number') }} "  type="text" id="mateRegNumber" class="w-full p-2 border border-gray-300 rounded-md" oninput="runningmateSearch(event)" />
          <div id="searchResultsRunningMates" class="mt-2"></div>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Programme of Study:</label>
          <input readonly name="running_mates_program" value="{{ old('running_mates_program') }} " type="text" id="mateProgram" class="w-full p-2 border border-gray-300 rounded-md" />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number:</label>
          <input readonly  name="running_mates_phone" value="{{ old('running_mates_phone') }} " type="tel" id="matePhone" class="w-full p-2 border border-gray-300 rounded-md" />
        </div>

        <div>
          <label class="inline-flex items-center">
            <input name="running_mates_status" type="checkbox" class="mr-2" />
            I (Running Mate) confirm the accuracy of my details provided above.
          </label>
        </div>
      </div>

      <div class="space-y-3">
        <h3 class="text-lg font-semibold mb-2">
          This nomination is supported by (Name and Address of two (2) persons)
        </h3>

        <!-- Guarantor 1 -->
        <div>
          <h4 class="text-base font-medium mb-2">Guarantor one</h4>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Reg. No:</label>
            <input name="guarantor[1][reg_number]" value="{{ old('guarantor[1][reg_number]') }} " type="text" id="guarantor1Reg" class="w-full p-2 border border-gray-300 rounded-md" oninput="searchGuarantorOne(event)" />
            <div id="searchResults1" class="mt-2"></div>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Name:</label>
            <input readonly name="guarantor[1][name]" value="{{ old('guarantor[1][name]') }} " type="text" id="guarantor1Name" class="w-full p-2 border border-gray-300 rounded-md" required />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Hall of Affiliation:</label>
            <input readonly name="guarantor[1][hall]" value="{{ old('guarantor[1][hall]') }} " type="text" id="guarantor1Hall" class="w-full p-2 border border-gray-300 rounded-md" required />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Department:</label>
            <input readonly  name="guarantor[1][department]" value="{{ old('guarantor[1][department]') }} "  type="text" id="guarantor1Dept" class="w-full p-2 border border-gray-300 rounded-md" required />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Programme of Study:</label>
            <input readonly  name="guarantor[1][program]" value="{{ old('guarantor[1][program]') }} "  type="text" id="guarantor1Program" class="w-full p-2 border border-gray-300 rounded-md" required />
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number:</label>
            <input readonly name="guarantor[1][phone]" value="{{ old('guarantor[1][phone]') }} " type="tel" id="guarantor1Phone" class="w-full p-2 border border-gray-300 rounded-md" required />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Email:</label>
            <input readonly name="guarantor[1][email]" value="{{ old('guarantor[1][email]') }} " type="email" id="guarantor1Email" class="w-full p-2 border border-gray-300 rounded-md" required />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Date:</label>
            <input  name="guarantor[1][date]" type="date" value="{{ old('guarantor[1][date]') }} " id="guarantor1Date" class="w-full p-2 border border-gray-300 rounded-md"  />
          </div>
          <div>
            <label class="inline-flex items-center">
              <input name="guarantor[1][verified]" type="checkbox" class="mr-2" />
              I (Guarantor 1) support this nomination.
            </label>
          </div>
        </div>

        <!-- Guarantor 2 -->
        <div>
          <h4 class="text-base font-medium mb-2">Guarantor two</h4>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Reg. No:</label>
            <input name="guarantor[2][reg_number]" value="{{ old('guarantor[2][reg_number]') }} " type="text" id="guarantor2Reg" class="w-full p-2 border border-gray-300 rounded-md" oninput="searchGuarantorTwo(event)" />
            <div id="searchResults2" class="mt-2"></div>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Name:</label>
            <input readonly name="guarantor[2][name]" value="{{ old('guarantor[2][name]') }} " type="text" id="guarantor2Name" class="w-full p-2 border border-gray-300 rounded-md" required />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Hall of Affiliation:</label>
            <input readonly  name="guarantor[2][hall]" value="{{ old('guarantor[2][hall]') }} " type="text" id="guarantor2Hall" class="w-full p-2 border border-gray-300 rounded-md" required />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Department:</label>
            <input readonly name="guarantor[2][department]" value="{{ old('guarantor[2][department]') }} " type="text" id="guarantor2Dept" class="w-full p-2 border border-gray-300 rounded-md" required />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Programme of Study:</label>
            <input readonly name="guarantor[2][program]" value="{{ old('guarantor[2][program]') }} " type="text" id="guarantor2Program" class="w-full p-2 border border-gray-300 rounded-md" required />
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number:</label>
            <input readonly name="guarantor[2][phone]" value="{{ old('guarantor[2][phone]') }} " type="tel" id="guarantor2Phone" class="w-full p-2 border border-gray-300 rounded-md" required />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Email:</label>
            <input readonly name="guarantor[2][email]" value="{{ old('guarantor[2][email]') }} " type="email" id="guarantor2Email" class="w-full p-2 border border-gray-300 rounded-md" required />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Date:</label>
            <input  name="guarantor[2][date]" value="{{ old('guarantor[2][date]') }} " type="date" id="guarantor2Date" class="w-full p-2 border border-gray-300 rounded-md"  />
          </div>
          <div>
            <label class="inline-flex items-center">
              <input name="guarantor[2][verified]" type="checkbox"  class="mr-2" />
              I (Guarantor 2) support this nomination.
            </label>
          </div>
        </div>
      </div>

      <div class="mt-6 flex justify-between">
        <button type="button" onclick="generatePrintableForm()" class="bg-blue-600 text-white px-4 py-2 m-2 rounded-md hover:bg-blue-700">
          Preview & Print Form
        </button>
        <button type="submit" name="action" value="save" class="bg-green-600 text-white px-4 py-2  m-2 rounded-md hover:bg-green-700">
          Save & Continue
        </button>
        <button type="submit" name="action" value="submit" class="bg-red-600 text-white px-4 py-2 m-2 rounded-md hover:bg-red-700">
          Submit Nomination
        </button>
      </div>
    </form>
  </div>

  <!-- Printable Form (hidden by default) -->
  <div id="printableForm" class="hidden max-w-4xl mx-auto bg-white p-6">
    <div class="text-center font-bold text-lg mb-4"><span class="currentAcademicYear"></span>  <span id="printFormTitle">SRC/LOCAL NUGS ELECTIONS NOMINATION FORM</span></div>
    
    <div class="mb-6">
      <div class="font-semibold mb-2">INSTRUCTIONS</div>
      <p class="text-sm mb-4">
        Please, write your full name clearly against the post for which you wish to contest and provide the requested information. Falsification of any information leads to automatic disqualification. 
        <strong>Note that Voucher expires 30th May, 2025</strong>
      </p>
    </div>

    <!-- Dynamic Portfolio Sections -->
    <div id="srcPortfolioSection">
      <div class="form-line">
        <div class="form-label">SRC President:</div>
        <div class="form-input" id="printPresident"></div>
      </div>
      <div class="form-line">
        <div class="form-label">Running Mate:</div>
        <div class="form-input" id="printRunningMate"></div>
      </div>
      <div class="form-line">
        <div class="form-label">SRC Secretary:</div>
        <div class="form-input" id="printSecretary"></div>
      </div>
      <div class="form-line">
        <div class="form-label">SRC Treasurer:</div>
        <div class="form-input" id="printTreasurer"></div>
      </div>
      <div class="form-line">
        <div class="form-label">General Sports Secretary:</div>
        <div class="form-input" id="printSports"></div>
      </div>
      <div class="form-line">
        <div class="form-label">SRC Coordinating Secretary:</div>
        <div class="form-input" id="printCoordinating"></div>
      </div>
      <div class="form-line">
        <div class="form-label">SRC Public Relations Officer:</div>
        <div class="form-input" id="printPRO"></div>
      </div>
      <div class="form-line">
        <div class="form-label">Local NUGS President:</div>
        <div class="form-input" id="printNUGS"></div>
      </div>
      <div class="form-line">
        <div class="form-label">Local NUGS Secretary:</div>
        <div class="form-input"></div>
      </div>
      <div class="form-line">
        <div class="form-label">Women's Commissioner:</div>
        <div class="form-input" id="printWomen"></div>
      </div>
    </div>
    
    <div id="jcrcPortfolioSection" class="hidden">
      <div class="form-line">
        <div class="form-label">JCRC President:</div>
        <div class="form-input" id="printJcrcPresident"></div>
      </div>
      <div class="form-line">
        <div class="form-label">Running Mate:</div>
        <div class="form-input" id="printJcrcRunningMate"></div>
      </div>
      <div class="form-line">
        <div class="form-label">JCRC Secretary:</div>
        <div class="form-input" id="printJcrcSecretary"></div>
      </div>
      <div class="form-line">
        <div class="form-label">JCRC Treasurer:</div>
        <div class="form-input" id="printJcrcTreasurer"></div>
      </div>
      <div class="form-line">
        <div class="form-label">JCRC Welfare Chairperson:</div>
        <div class="form-input" id="printJcrcWelfare"></div>
      </div>
      <div class="form-line">
        <div class="form-label">JCRC Sport Secretary:</div>
        <div class="form-input" id="printJcrcSports"></div>
      </div>
      <div class="form-line">
        <div class="form-label">JCRC Library Chairperson:</div>
        <div class="form-input" id="printJcrcLibrary"></div>
      </div>
    </div>
    
    <div id="grasagPortfolioSection" class="hidden">
      <div class="form-line">
        <div class="form-label">GRASAG President:</div>
        <div class="form-input" id="printGrasagPresident"></div>
      </div>
      <div class="form-line">
        <div class="form-label">Running Mate:</div>
        <div class="form-input" id="printGrasagRunningMate"></div>
      </div>
      <div class="form-line">
        <div class="form-label">GRASAG Secretary:</div>
        <div class="form-input" id="printGrasagSecretary"></div>
      </div>
      <div class="form-line">
        <div class="form-label">GRASAG Treasurer:</div>
        <div class="form-input" id="printGrasagTreasurer"></div>
      </div>
      <div class="form-line">
        <div class="form-label">GRASAG Financial Secretary:</div>
        <div class="form-input" id="printGrasagFinancial"></div>
      </div>
      <div class="form-line">
        <div class="form-label">GRASAG Organising Secretary:</div>
        <div class="form-input" id="printGrasagOrganising"></div>
      </div>
      <div class="form-line">
        <div class="form-label">GRASAG Women's Commissioner:</div>
        <div class="form-input" id="printGrasagWomen"></div>
      </div>
    </div>

    <div class="flex mt-6 ">
      <div class="w-1/2 pr-4">
        <div class="form-line">
          <div class="form-label">Hall of affiliation:</div>
          <div class="form-input" id="printHall"></div>
        </div>
        <div class="form-line">
          <div class="form-label">Programme of Study:</div>
          <div class="form-input" id="printProgram"></div>
        </div>
        <div class="form-line">
          <div class="form-label">Registration No:</div>
          <div class="form-input" id="printRegNumber"></div>
        </div>
        <div class="form-line">
          <div class="form-label">Phone Number:</div>
          <div class="form-input" id="printPhone"></div>
        </div>
        <div class="form-line">
          <div class="form-label">Signature:</div>
          <div class="signature-line"></div>
          <div class="form-label">Date:</div>
          <div class="signature-line"></div>
        </div>
      </div>
      <div class="w-1/2 pl-4">
        <div id="runningMatePrintSection">
          <div class="form-line">
            <div class="form-label">For Running Mates Only</div>
            <div class="form-input"></div>
          </div>
          <div class="form-line">
            <div class="form-label">Programme of Study:</div>
            <div class="form-input" id="printMateProgram"></div>
          </div>
          <div class="form-line">
            <div class="form-label">Registration No:</div>
            <div class="form-input" id="printMateRegNumber"></div>
          </div>
          <div class="form-line">
            <div class="form-label">Phone Number:</div>
            <div class="form-input" id="printMatePhone"></div>
          </div>
          <div class="form-line">
            <div class="form-label">Signature:</div>
            <div class="signature-line"></div>
            <div class="form-label">Date:</div>
            <div class="signature-line"></div>
          </div>
        </div>
      </div>
    </div>
   
    <div class="mt-[150px]">
      <p>This nomination is supported by (Name and Address of two (2) persons)</p>
      
      <div class="mt-4">
        <div class="form-line">
          <div class="form-label">1. Name:</div>
          <div class="form-input" id="printGuarantor1Name"></div>
        </div>
        <div class="form-line">
          <div class="form-label">Hall of Affiliation:</div>
          <div class="form-input" id="printGuarantor1Hall"></div>
          <div class="form-label">Department:</div>
          <div class="form-input" id="printGuarantor1Dept"></div>
        </div>
        <div class="form-line">
          <div class="form-label">Programme of Study:</div>
          <div class="form-input" id="printGuarantor1Program"></div>
          <div class="form-label">Reg.No:</div>
          <div class="form-input" id="printGuarantor1Reg"></div>
        </div>
        <div class="form-line">
          <div class="form-label">Phone Number:</div>
          <div class="form-input" id="printGuarantor1Phone"></div>
        </div>
        <div class="form-line">
          <div class="form-label">Signature:</div>
          <div class="signature-line"></div>
          <div class="form-label">Date:</div>
          <div class="form-input" id="printGuarantor1Date"></div>
        </div>
      </div>
      
      <div class="mt-4">
        <div class="form-line">
          <div class="form-label">2. Name:</div>
          <div class="form-input" id="printGuarantor2Name"></div>
        </div>
        <div class="form-line">
          <div class="form-label">Hall of Affiliation:</div>
          <div class="form-input" id="printGuarantor2Hall"></div>
          <div class="form-label">Department:</div>
          <div class="form-input" id="printGuarantor2Dept"></div>
        </div>
        <div class="form-line">
          <div class="form-label">Programme of Study:</div>
          <div class="form-input" id="printGuarantor2Program"></div>
          <div class="form-label">Reg.No:</div>
          <div class="form-input" id="printGuarantor2Reg"></div>
        </div>
        <div class="form-line">
          <div class="form-label">Phone Number:</div>
          <div class="form-input" id="printGuarantor2Phone"></div>
        </div>
        <div class="form-line">
          <div class="form-label">Signature:</div>
          <div class="signature-line"></div>
          <div class="form-label">Date:</div>
          <div class="form-input" id="printGuarantor2Date"></div>
        </div>
      </div>
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
    <div class="mt-[260px]">
      <div class="text-center font-bold mb-4">UNIVERSITY OF CAPE COAST</div>
      <div class="text-center font-bold mb-4">OFFICE OF THE DEAN OF STUDENTS</div>
      <div class="font-semibold text-center mb-4">DECLARATION TO ABIDE BY UCC REGULATIONS ON THE CONDUCT OF  <span class="currentAcademicYear"> </span> ELECTIONS</div>
      
      <div class="declaration-box">
        <p>I, <span class="form-input inline-block w-64" id="printDeclareName"></span>,</p>
        <p>an aspirant in the  SRC/L.NUGS/GRASAG/ICRC elections, for the position of <span class="form-input inline-block w-64" id="printDeclarePortfolio"></span></p>
        <p>do hereby pledge to abide by all rules and regulations governing elections and students conduct on UCC campus during the electioneering and voting period, and that should I or any of my polling agents/supporters do contrary, I be disqualified from the said elections.</p>
        
        <div class="mt-8">
          <div class="form-line">
            <div class="form-label">Name:</div>
            <div class="form-input" id="printDeclareName2"></div>
          </div>
          <div class="form-line">
            <div class="form-label">Registration Number:</div>
            <div class="form-input" id="printDeclareReg"></div>
          </div>
          <div class="form-line">
            <div class="form-label">Signature:</div>
            <div class="signature-line"></div>
          </div>
        </div>
      </div>
    </div>

    <!-- Instructions -->
    <div class="mt-[550px]">
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
    </div>
  </div>

  <script>
    const draftNominee = @json($draftNominee);
    const runningMateDraft = @json($runningMateDraft);
    const supporterOneDraft = @json($supporterOneDraft);
    const supporterTwoDraft = @json($supporterTwoDraft);

    function setIfEmpty(id, value) {
      const el = document.getElementById(id);
      if (!el || value === null || value === undefined) return;
      let normalizedValue = value;
      if (el.type === 'date' && typeof normalizedValue === 'string' && normalizedValue.includes('T')) {
        normalizedValue = normalizedValue.slice(0, 10);
      }

      if ('value' in el) {
        if (String(el.value).trim() === '') {
          el.value = normalizedValue;
        }
      } else if (String(el.textContent).trim() === '') {
        el.textContent = normalizedValue;
      }
    }

    document.addEventListener('DOMContentLoaded', function() {
      if (draftNominee) {
        setIfEmpty('portfolio', draftNominee.position);
        setIfEmpty('regNumber', draftNominee.reg_number);
        setIfEmpty('fullName', draftNominee.full_name);
        setIfEmpty('hall', draftNominee.hall);
        setIfEmpty('program', draftNominee.program);
        setIfEmpty('phone', draftNominee.phone);
        setIfEmpty('nominee_cgpa', draftNominee.nominee_cgpa);

        if (runningMateDraft) {
          setIfEmpty('mateRegNumber', runningMateDraft.running_mates_reg_number);
          setIfEmpty('mateProgram', runningMateDraft.running_mates_program);
          setIfEmpty('matePhone', runningMateDraft.running_mates_phone);
          setIfEmpty('running_mates_cgpa', runningMateDraft.running_mates_cgpa);
          setIfEmpty('running_mates_full_name', runningMateDraft.running_mates_full_name);
          setIfEmpty('running_mates_hall', runningMateDraft.running_mates_hall);
          setIfEmpty('printRunningMate', runningMateDraft.running_mates_full_name);
        }

        if (supporterOneDraft) {
          setIfEmpty('guarantor1Reg', supporterOneDraft.reg_number);
          setIfEmpty('guarantor1Name', supporterOneDraft.name);
          setIfEmpty('guarantor1Hall', supporterOneDraft.hall);
          setIfEmpty('guarantor1Dept', supporterOneDraft.department);
          setIfEmpty('guarantor1Program', supporterOneDraft.program);
          setIfEmpty('guarantor1Phone', supporterOneDraft.phone);
          setIfEmpty('guarantor1Email', supporterOneDraft.email);
          setIfEmpty('guarantor1Date', supporterOneDraft.date);
        }

        if (supporterTwoDraft) {
          setIfEmpty('guarantor2Reg', supporterTwoDraft.reg_number);
          setIfEmpty('guarantor2Name', supporterTwoDraft.name);
          setIfEmpty('guarantor2Hall', supporterTwoDraft.hall);
          setIfEmpty('guarantor2Dept', supporterTwoDraft.department);
          setIfEmpty('guarantor2Program', supporterTwoDraft.program);
          setIfEmpty('guarantor2Phone', supporterTwoDraft.phone);
          setIfEmpty('guarantor2Email', supporterTwoDraft.email);
          setIfEmpty('guarantor2Date', supporterTwoDraft.date);
        }
      }

      const portfolioSelect = document.getElementById('portfolio');
      if (portfolioSelect) {
        portfolioSelect.dispatchEvent(new Event('change'));
      }
    });

    // Show/hide running mate section based on portfolio selection
    document.getElementById('portfolio').addEventListener('change', function() {
      const runningMateSection = document.getElementById('runningMateSection');
      if (this.value === 'SRC President' || this.value === 'JCRC President' || this.value === 'GRASAG President') {
        runningMateSection.classList.remove('hidden');
      } else {
        runningMateSection.classList.add('hidden');
      }
    });
    
    function runningmateSearch(event) {
      const input = event.target;
      const resultsDiv = document.getElementById('searchResultsRunningMates');
      const searchValue = input.value.trim();

      if (searchValue.length > 0) {
          resultsDiv.innerHTML = '<p class="text-gray-500">Searching...</p>';
          
          fetch(`/search-nominee-user?search_value=${encodeURIComponent(searchValue)}`, { 
              headers: { 
                  'X-Requested-With': 'XMLHttpRequest', 
                  'Accept': 'application/json'
              }
          })
          .then(response => {
              if (!response.ok) throw new Error(response.statusText);
              return response.json();
          })
          .then(data => {
              console.log('API Response:', data);
              
              if (data && data.length > 0) {
                  resultsDiv.innerHTML = data.map(user => `
                      <div class="flex justify-between items-center bg-gray-100 p-2 rounded mb-1">
                          <div>
                              <span class="font-medium">${user.firstName} ${user.lastName}</span>
                              <span class="text-gray-500 ml-2">(${user.schoolId})</span>
                              <div class="text-sm">
                                  ${user.program} • ${user.hall} • CGPA: ${user.cgpa || 'N/A'}
                              </div>
                          </div>
                          <button type="button" onclick="selectUserForRunningMate(this)"
                                  data-user='${JSON.stringify(user).replace(/'/g, "\\'")}'
                                  class="text-blue-600 hover:bg-blue-100 px-2 py-1 rounded">
                              fetch Running Mate Data
                          </button>
                      </div>
                  `).join('');
              } else {
                  resultsDiv.innerHTML = '<p class="text-red-500">No results found</p>';
              }
          })
          .catch(error => {
              console.error('Search error:', error);
              resultsDiv.innerHTML = `
                  <p class="text-red-500">
                      Search failed. 
                      <button onclick="selectUserForRunningMate(event)" class="text-blue-500 ml-1">Retry</button>
                  </p>
              `;
          });
      } else {
          resultsDiv.innerHTML = '';
      }
    }

    function searchGuarantorTwo(event) {
      const input = event.target;
      const resultsDiv = document.getElementById('searchResults2');
      const searchValue = input.value.trim();

      if (searchValue.length > 0) {
          resultsDiv.innerHTML = '<p class="text-gray-500">Searching...</p>';
          
          fetch(`/search-nominee-user?search_value=${encodeURIComponent(searchValue)}`, { 
              headers: { 
                  'X-Requested-With': 'XMLHttpRequest', 
                  'Accept': 'application/json'
              }
          })
          .then(response => {
              if (!response.ok) throw new Error(response.statusText);
              return response.json();
          })
          .then(data => {
              console.log('API Response:', data);
              
              if (data && data.length > 0) {
                  resultsDiv.innerHTML = data.map(user => `
                      <div class="flex justify-between items-center bg-gray-100 p-2 rounded mb-1">
                          <div>
                              <span class="font-medium">${user.firstName} ${user.lastName}</span>
                              <span class="text-gray-500 ml-2">(${user.schoolId})</span>
                              <div class="text-sm">
                                  ${user.program} • ${user.hall}
                              </div>
                          </div>
                          <button type="button" onclick="selectUserForGuarantorTwo(this)"
                                  data-user='${JSON.stringify(user).replace(/'/g, "\\'")}'
                                  class="text-blue-600 hover:bg-blue-100 px-2 py-1 rounded">
                               fetch Guarantor Two Data
                          </button>
                      </div>
                  `).join('');
              } else {
                  resultsDiv.innerHTML = '<p class="text-red-500">No results found</p>';
              }
          })
          .catch(error => {
              console.error('Search error:', error);
              resultsDiv.innerHTML = `
                  <p class="text-red-500">
                      Search failed. 
                      <button onclick="selectUserForGuarantorTwo(event)" class="text-blue-500 ml-1">Retry</button>
                  </p>
              `;
          });
      } else {
          resultsDiv.innerHTML = '';
      }
    }

    function searchGuarantorOne(event) {
      const input = event.target;
      const resultsDiv = document.getElementById('searchResults1');
      const searchValue = input.value.trim();

      if (searchValue.length > 0) {
          resultsDiv.innerHTML = '<p class="text-gray-500">Searching...</p>';
          
          fetch(`/search-nominee-user?search_value=${encodeURIComponent(searchValue)}`, { 
              headers: { 
                  'X-Requested-With': 'XMLHttpRequest', 
                  'Accept': 'application/json'
              }
          })
          .then(response => {
              if (!response.ok) throw new Error(response.statusText);
              return response.json();
          })
          .then(data => {
              console.log('API Response:', data);
              
              if (data && data.length > 0) {
                  resultsDiv.innerHTML = data.map(user => `
                      <div class="flex justify-between items-center bg-gray-100 p-2 rounded mb-1">
                          <div>
                              <span class="font-medium">${user.firstName} ${user.lastName}</span>
                              <span class="text-gray-500 ml-2">(${user.schoolId})</span>
                              <div class="text-sm">
                                  ${user.program} • ${user.hall}
                              </div>
                          </div>
                          <button type="button" onclick="selectUserForGuarantorOne(this)"
                                  data-user='${JSON.stringify(user).replace(/'/g, "\\'")}'
                                  class="text-blue-600 hover:bg-blue-100 px-2 py-1 rounded">
                              Fetch Guarantor One Data
                          </button>
                      </div>
                  `).join('');
              } else {
                  resultsDiv.innerHTML = '<p class="text-red-500">No results found</p>';
              }
          })
          .catch(error => {
              console.error('Search error:', error);
              resultsDiv.innerHTML = `
                  <p class="text-red-500">
                      Search failed. 
                      <button onclick="searchGuarantorOne(event)" class="text-blue-500 ml-1">Retry</button>
                  </p>
              `;
          });
      } else {
          resultsDiv.innerHTML = '';
      }
    }

    // Search user functionality
    function searchUser(event) {
      const input = event.target;
      const resultsDiv = document.getElementById('searchResults');
      const searchValue = input.value.trim();

      if (searchValue.length > 0) {
          resultsDiv.innerHTML = '<p class="text-gray-500">Searching...</p>';
          
          fetch(`/search-nominee-user?search_value=${encodeURIComponent(searchValue)}`, { 
              headers: { 
                  'X-Requested-With': 'XMLHttpRequest', 
                  'Accept': 'application/json'
              }
          })
          .then(response => {
              if (!response.ok) throw new Error(response.statusText);
              return response.json();
          })
          .then(data => {
              console.log('API Response:', data); // Debug log
              
              if (data && data.length > 0) {
                  resultsDiv.innerHTML = data.map(user => `
                      <div class="flex justify-between items-center bg-gray-100 p-2 rounded mb-1">
                          <div>
                              <span class="font-medium">${user.firstName} ${user.lastName}</span>
                              <span class="text-gray-500 ml-2">(${user.schoolId})</span>
                              <div class="text-sm">
                                  ${user.program} • CGPA: ${user.cgpa || 'N/A'}
                              </div>
                          </div>
                          <button type="button" onclick="selectUser(this)"
                                  data-user='${JSON.stringify(user).replace(/'/g, "\\'")}'
                                  class="text-blue-600 hover:bg-blue-100 px-2 py-1 rounded">
                              Fetch Data
                          </button>
                      </div>
                  `).join('');
              } else {
                  resultsDiv.innerHTML = '<p class="text-red-500">No results found</p>';
              }
          })
          .catch(error => {
              console.error('Search error:', error);
              resultsDiv.innerHTML = `
                  <p class="text-red-500">
                      Search failed. 
                      <button onclick="searchUser(event)" class="text-blue-500 ml-1">Retry</button>
                  </p>
              `;
          });
      } else {
          resultsDiv.innerHTML = '';
      }
    }

    function selectUserForGuarantorTwo(button) {
      const userData = button.getAttribute('data-user');
      let user;
      
      try {
          user = JSON.parse(userData);
      } catch (e) {
          try {
              user = JSON.parse(userData
                  .replace(/&#39;/g, "'")
                  .replace(/\\'/g, "'"));
          } catch (error) {
              console.error('Selection error:', error);
              alert('Failed to select guarantor. Invalid data format.');
              return;
          }
      }
      
      // Fill guarantor one fields
      document.getElementById('guarantor2Name').value = `${user.firstName} ${user.lastName}`;
      document.getElementById('guarantor2Reg').value = user.schoolId;
      document.getElementById('guarantor2Hall').value = user.hall;
      document.getElementById('guarantor2Program').value = user.program;
      document.getElementById('guarantor2Dept').value = user.department;
      document.getElementById('guarantor2Phone').value = user.phone || '';
        document.getElementById('guarantor2Email').value = user.email;
      // Clear search results
      document.getElementById('searchResults2').innerHTML = '';
      document.getElementById('searchGuarantortwo').value = '';
    }

    function selectUserForRunningMate(button) {
      const userData = button.getAttribute('data-user');
      let user;
      
      try {
          user = JSON.parse(userData);
      } catch (e) {
          try {
              user = JSON.parse(userData
                  .replace(/&#39;/g, "'")
                  .replace(/\\'/g, "'"));
          } catch (error) {
              console.error('Selection error:', error);
              alert('Failed to select guarantor. Invalid data format.');
              return;
          }
      }
      
      // Fill running mate fields
      document.getElementById('printRunningMate').textContent = `${user.firstName} ${user.lastName}`;
      document.getElementById('mateRegNumber').value = user.schoolId;
      document.getElementById('mateProgram').value = user.program;
      document.getElementById('matePhone').value = user.phone || '';
      document.getElementById('running_mates_cgpa').value = user.cgpa;
      document.getElementById('running_mates_full_name').value = `${user.firstName} ${user.lastName}`;
      document.getElementById('running_mates_hall').value = user.hall;

      // Clear search results
      document.getElementById('searchResultsRunningMates').innerHTML = '';
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Get current date
        const currentDate = new Date();
        const currentYear = currentDate.getFullYear();
        const currentMonth = currentDate.getMonth() + 1; // Months are 0-indexed
        
        // Academic year runs from August to July
        const academicYear = (currentMonth >= 8) 
            ? `${currentYear}/${currentYear + 1}`
            : `${currentYear - 1}/${currentYear}`;
        
        // Update ALL academic year elements
        const academicYearElements = document.querySelectorAll('.currentAcademicYear');
        academicYearElements.forEach(element => {
            element.textContent = academicYear;
        });
    });

    function selectUserForGuarantorOne(button) {
      const userData = button.getAttribute('data-user');
      let user;
      
      try {
          user = JSON.parse(userData);
      } catch (e) {
          try {
              user = JSON.parse(userData
                  .replace(/&#39;/g, "'")
                  .replace(/\\'/g, "'"));
          } catch (error) {
              console.error('Selection error:', error);
              alert('Failed to select guarantor. Invalid data format.');
              return;
          }
      }
      
      // Fill guarantor one fields
      document.getElementById('guarantor1Name').value = `${user.firstName} ${user.lastName}`;
      document.getElementById('guarantor1Reg').value = user.schoolId;
      document.getElementById('guarantor1Hall').value = user.hall;
      document.getElementById('guarantor1Program').value = user.program;
       document.getElementById('guarantor1Email').value = user.email;
      document.getElementById('guarantor1Dept').value = user.department;
      document.getElementById('guarantor1Phone').value = user.phone || '';
      
      // Clear search results
      document.getElementById('searchResults1').innerHTML = '';
    }

    function selectUser(button) {
      const userData = button.getAttribute('data-user');
      let user;
      
      // First try parsing directly
      try {
          user = JSON.parse(userData);
      } catch (e) {
          // If direct parse fails, try with replacements
          try {
              user = JSON.parse(userData
                  .replace(/&#39;/g, "'")
                  .replace(/\\'/g, "'"));
          } catch (error) {
              console.error('Selection error:', error);
              alert('Failed to select user. Invalid data format.');
              return; // Exit the function if parsing fails
          }
      }
      
      // Fill form fields
      document.getElementById('fullName').value = `${user.firstName} ${user.lastName}`;
      document.getElementById('regNumber').value = user.schoolId;
      document.getElementById('hall').value = user.hall;
      document.getElementById('program').value = user.program;
      document.getElementById('phone').value = user.phone;
      document.getElementById('nominee_cgpa').value = user.cgpa;
      
      // Clear search results
      document.getElementById('searchResults').innerHTML = '';
    }

    // Generate printable form
    function generatePrintableForm() {
      // Get form values
      const portfolio = document.getElementById('portfolio').value;
      const fullName = document.getElementById('fullName').value;
      const regNumber = document.getElementById('regNumber').value;
      const hall = document.getElementById('hall').value;
      const program = document.getElementById('program').value;
      const phone = document.getElementById('phone').value;
      const mateRegNumber = document.getElementById('mateRegNumber').value;
      const mateProgram = document.getElementById('mateProgram').value;
      const RunningMateName = document.getElementById('printRunningMate').textContent;
      const matePhone = document.getElementById('matePhone').value;
      const guarantor1Name = document.getElementById('guarantor1Name').value;
      const guarantor1Reg = document.getElementById('guarantor1Reg').value;
      const guarantor1Hall = document.getElementById('guarantor1Hall').value;
      const guarantor1Dept = document.getElementById('guarantor1Dept').value;
      const guarantor1Program = document.getElementById('guarantor1Program').value;
      const guarantor1Phone = document.getElementById('guarantor1Phone').value;
      const guarantor1Date = document.getElementById('guarantor1Date').value;
      const guarantor2Name = document.getElementById('guarantor2Name').value;
      const guarantor2Reg = document.getElementById('guarantor2Reg').value;
      const guarantor2Hall = document.getElementById('guarantor2Hall').value;
      const guarantor2Dept = document.getElementById('guarantor2Dept').value;
      const guarantor2Program = document.getElementById('guarantor2Program').value;
      const guarantor2Phone = document.getElementById('guarantor2Phone').value;
      const guarantor2Date = document.getElementById('guarantor2Date').value;

      // Determine which form template to show
      let formTitle = '';
      if (portfolio.includes('SRC') || portfolio.includes('NUGS')) {
        formTitle = 'SRC/LOCAL NUGS ELECTIONS NOMINATION FORM';
        document.getElementById('srcPortfolioSection').classList.remove('hidden');
        document.getElementById('jcrcPortfolioSection').classList.add('hidden');
        document.getElementById('grasagPortfolioSection').classList.add('hidden');
        
        // Set SRC-specific fields
        document.getElementById('printPresident').textContent = portfolio === 'SRC President' ? fullName : '';
        document.getElementById('printSecretary').textContent = portfolio === 'SRC Secretary' ? fullName : '';
        document.getElementById('printTreasurer').textContent = portfolio === 'SRC Treasurer' ? fullName : '';
        document.getElementById('printSports').textContent = portfolio === 'SRC General Sports Secretary' ? fullName : '';
        document.getElementById('printCoordinating').textContent = portfolio === 'SRC Coordinating Secretary' ? fullName : '';
        document.getElementById('printPRO').textContent = portfolio === 'SRC Public Relations Officer' ? fullName : '';
        document.getElementById('printNUGS').textContent = portfolio === 'Local NUGS President' ? fullName : '';
        document.getElementById('printWomen').textContent = portfolio === "SRC Women's Commissioner" ? fullName : '';
      } 
      else if (portfolio.includes('JCRC')) {
        formTitle = 'JCRC ELECTIONS NOMINATION FORM';
        document.getElementById('srcPortfolioSection').classList.add('hidden');
        document.getElementById('jcrcPortfolioSection').classList.remove('hidden');
        document.getElementById('grasagPortfolioSection').classList.add('hidden');
        
        // Set JCRC-specific fields
        document.getElementById('printJcrcPresident').textContent = portfolio === 'JCRC President' ? fullName : '';
        document.getElementById('printJcrcSecretary').textContent = portfolio === 'JCRC Secretary' ? fullName : '';
        document.getElementById('printJcrcTreasurer').textContent = portfolio === 'JCRC Treasurer' ? fullName : '';
        document.getElementById('printJcrcWelfare').textContent = portfolio === 'JCRC Welfare Chairperson' ? fullName : '';
        document.getElementById('printJcrcSports').textContent = portfolio === 'JCRC Sport Secretary' ? fullName : '';
        document.getElementById('printJcrcLibrary').textContent = portfolio === 'JCRC Library Chairperson' ? fullName : '';
      } 
      else if (portfolio.includes('GRASAG')) {
        formTitle = 'GRASAG ELECTIONS NOMINATION FORM';
        document.getElementById('srcPortfolioSection').classList.add('hidden');
        document.getElementById('jcrcPortfolioSection').classList.add('hidden');
        document.getElementById('grasagPortfolioSection').classList.remove('hidden');
        
        // Set GRASAG-specific fields
        document.getElementById('printGrasagPresident').textContent = portfolio === 'GRASAG President' ? fullName : '';
        document.getElementById('printGrasagSecretary').textContent = portfolio === 'GRASAG Secretary' ? fullName : '';
        document.getElementById('printGrasagTreasurer').textContent = portfolio === 'GRASAG Treasurer' ? fullName : '';
        document.getElementById('printGrasagFinancial').textContent = portfolio === 'GRASAG Financial Secretary' ? fullName : '';
        document.getElementById('printGrasagOrganising').textContent = portfolio === 'GRASAG Organising Secretary' ? fullName : '';
        document.getElementById('printGrasagWomen').textContent = portfolio === "GRASAG Women's Commissioner" ? fullName : '';
      }

      // Set form title
      document.getElementById('printFormTitle').textContent = formTitle;

      // Set common fields
      document.getElementById('printHall').textContent = hall;
      document.getElementById('printProgram').textContent = program;
      document.getElementById('printRegNumber').textContent = regNumber;
      document.getElementById('printPhone').textContent = phone;
      
      // Set running mate fields if applicable
      if (portfolio === 'SRC President' || portfolio === 'JCRC President' || portfolio === 'GRASAG President') {
        document.getElementById('printMateProgram').textContent = mateProgram;
        document.getElementById('printMateRegNumber').textContent = mateRegNumber;
        document.getElementById('printMatePhone').textContent = matePhone;
        if (portfolio === 'SRC President') {
          document.getElementById('printRunningMate').textContent = RunningMateName;
        } else if (portfolio === 'JCRC President') {
          document.getElementById('printJcrcRunningMate').textContent = RunningMateName;
        } else if (portfolio === 'GRASAG President') {
          document.getElementById('printGrasagRunningMate').textContent = RunningMateName;
        }
      }
      
      // Set guarantor fields
      document.getElementById('printGuarantor1Name').textContent = guarantor1Name;
      document.getElementById('printGuarantor1Reg').textContent = guarantor1Reg;
      document.getElementById('printGuarantor1Hall').textContent = guarantor1Hall;
      document.getElementById('printGuarantor1Dept').textContent = guarantor1Dept;
      document.getElementById('printGuarantor1Program').textContent = guarantor1Program;
      document.getElementById('printGuarantor1Phone').textContent = guarantor1Phone;
      document.getElementById('printGuarantor1Date').textContent = guarantor1Date;
      
      document.getElementById('printGuarantor2Name').textContent = guarantor2Name;
      document.getElementById('printGuarantor2Reg').textContent = guarantor2Reg;
      document.getElementById('printGuarantor2Hall').textContent = guarantor2Hall;
      document.getElementById('printGuarantor2Dept').textContent = guarantor2Dept;
      document.getElementById('printGuarantor2Program').textContent = guarantor2Program;
      document.getElementById('printGuarantor2Phone').textContent = guarantor2Phone;
      document.getElementById('printGuarantor2Date').textContent = guarantor2Date;
      
      // Set declaration fields
      document.getElementById('printDeclareName').textContent = fullName;
      document.getElementById('printDeclareName2').textContent = fullName;
      document.getElementById('printDeclarePortfolio').textContent = portfolio;
      document.getElementById('printDeclareReg').textContent = regNumber;

      // Show printable form and hide main form
      document.getElementById('printableForm').classList.remove('hidden');
      document.querySelector('.no-print').classList.add('hidden');
    }

    // Close print view
    function closePrintView() {
      document.getElementById('printableForm').classList.add('hidden');
      document.querySelector('.no-print').classList.remove('hidden');
    }
  </script>
</body>
</html>
@else
<script>
	window.location.href = "{{ route('/normination-landing-page') }}";
</script>
@endauth
