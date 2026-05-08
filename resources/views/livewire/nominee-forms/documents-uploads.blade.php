@auth('ticket')
@php
    $existingDocs = $existingDocs ?? collect();
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UCC-EVOTE Document Submission</title>
    <link rel="icon" href="/images/logo60.jpg" type="image/x-icon" class="rounded-full w-16 h-16">
    @vite(["resources/css/app.css","resources/js/app.js"])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    @if(session('success') || session('error'))
        <div class="fixed top-4 right-4 z-50">
            @if(session('success'))
                <div class="bg-green-500 text-white px-6 py-4 rounded-lg shadow-xl transition-all duration-300 ease-in-out animate-bounce mb-2">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif
    
            @if(session('error'))
                <div class="bg-red-500 text-white px-6 py-4 rounded-lg shadow-xl transition-all duration-300 ease-in-out animate-bounce">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                </div>
            @endif
        </div>
    
        <script>
            // Auto-dismiss messages after 5 seconds
            setTimeout(() => {
                document.querySelectorAll('.bg-green-500, .bg-red-500').forEach((message) => {
                    message.classList.add('animate-fadeOut');
                    setTimeout(() => message.remove(), 500);
                });
            }, 5000);
        </script>
    @endif

    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-blue-800 mb-2">UCC Election Document Submission</h1>
            <p class="text-gray-600">Please upload all required documents for your nomination</p>
            <p class="text-red-600 font-bold"><a href="https://www.ilovepdf.com/compress_pdf">Click Here To Reduce The Size Of The PDF</a></p>
            
        </div>

        <!-- Submission Form -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <form method="POST" action="{{ route('nomination.documents.store', $user) }}" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Student Information -->
                <p class="text-lg text-ucc-navy text-center my-5 p-3 bg-yellow-50 border-l-4 border-ucc-gold">
                    Hello Aspirant <span class="font-semibold">{{ $user->full_name }}</span>, congratulations!
                </p>

                <!-- Document Upload Section -->
                <div class="space-y-6">
                    <!-- CGPA/Academic Records -->
                    <div class="space-y-2">
                        <label for="cgpa_file" class="block text-sm font-medium text-gray-700">
                            <i class="fas fa-file-alt mr-2"></i>
                            Evidence of Most Recent CGPA
                            <span class="text-xs text-gray-500">(For medical students, upload academic records)</span>
                        </label>
                        <div class="flex items-center gap-4">
                            <div class="flex-1">
                                <input type="file" id="cgpa_file" name="cgpa_file" accept=".pdf,.jpg,.jpeg,.png" 
                                       class="block w-full text-sm text-gray-500
                                       file:mr-4 file:py-2 file:px-4
                                       file:rounded-md file:border-0
                                       file:text-sm file:font-semibold
                                       file:bg-blue-50 file:text-blue-700
                                       hover:file:bg-blue-100"
                                       >
                            </div>
                        </div>
                        <p class="text-xs text-gray-500">PDF, JPG, or PNG (Max 5MB)</p>
                        @if($existingDocs->has('cgpa'))
                            <p class="text-xs text-green-600">Existing file saved. Upload again to replace it.</p>
                        @endif
                        @error('cgpa_file')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Fee Receipt -->
                    <div class="space-y-2">
                        <label for="fee_receipt" class="block text-sm font-medium text-gray-700">
                            <i class="fas fa-receipt mr-2"></i>
                            Receipt of Fees Paid for Current Academic Year
                        </label>
                        <div class="flex items-center gap-4">
                            <div class="flex-1">
                                <input type="file" id="fee_receipt" name="fee_receipt" accept=".pdf,.jpg,.jpeg,.png" 
                                       class="block w-full text-sm text-gray-500
                                       file:mr-4 file:py-2 file:px-4
                                       file:rounded-md file:border-0
                                       file:text-sm file:font-semibold
                                       file:bg-blue-50 file:text-blue-700
                                       hover:file:bg-blue-100"
                                       >
                            </div>
                        </div>
                        <p class="text-xs text-gray-500">PDF, JPG, or PNG (Max 5MB)</p>
                        @if($existingDocs->has('fee_receipt'))
                            <p class="text-xs text-green-600">Existing file saved. Upload again to replace it.</p>
                        @endif
                        @error('fee_receipt')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Curriculum Vitae -->
                    <div class="space-y-2">
                        <label for="cv_file" class="block text-sm font-medium text-gray-700">
                            <i class="fas fa-file-contract mr-2"></i>
                            Curriculum Vitae (CV)
                        </label>
                        <p class="text-xs text-gray-600 mb-2">Must include details of 2 referees (phone & email). One must be a Lecturer/Head of Institution.</p>
                        <div class="flex items-center gap-4">
                            <div class="flex-1">
                                <input type="file" id="cv_file" name="cv_file" accept=".pdf,.doc,.docx" 
                                       class="block w-full text-sm text-gray-500
                                       file:mr-4 file:py-2 file:px-4
                                       file:rounded-md file:border-0
                                       file:text-sm file:font-semibold
                                       file:bg-blue-50 file:text-blue-700
                                       hover:file:bg-blue-100"
                                       >
                            </div>
                        </div>
                        <p class="text-xs text-gray-500">PDF or DOCX (Max 5MB)</p>
                        @if($existingDocs->has('cv'))
                            <p class="text-xs text-green-600">Existing file saved. Upload again to replace it.</p>
                        @endif
                        @error('cv_file')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Medical Report -->
                    <div class="space-y-2">
                        <label for="medical_report" class="block text-sm font-medium text-gray-700">
                            <i class="fas fa-file-medical mr-2"></i>
                            Current Medical Report (from University Hospital)
                        </label>
                        <div class="flex items-center gap-4">
                            <div class="flex-1">
                                <input type="file" id="medical_report" name="medical_report" accept=".pdf,.jpg,.jpeg,.png" 
                                       class="block w-full text-sm text-gray-500
                                       file:mr-4 file:py-2 file:px-4
                                       file:rounded-md file:border-0
                                       file:text-sm file:font-semibold
                                       file:bg-blue-50 file:text-blue-700
                                       hover:file:bg-blue-100"
                                       >
                            </div>
                        </div>
                        <p class="text-xs text-gray-500">PDF, JPG, or PNG (Max 5MB)</p>
                        @if($existingDocs->has('medical_report'))
                            <p class="text-xs text-green-600">Existing file saved. Upload again to replace it.</p>
                        @endif
                        @error('medical_report')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Photo Upload -->
                    <div class="space-y-2">
                        <label for="passport_photo" class="block text-sm font-medium text-gray-700">
                            <i class="fas fa-camera mr-2"></i>
                            Campaign Photo (JPEG Format)
                        </label>
                        <p class="text-xs text-gray-600 mb-2">To be used throughout election process if successful</p>
                        <div class="flex items-center gap-4">
                            <div class="flex-1">
                                <input type="file" id="passport_photo" name="passport_photo" accept=".jpg,.jpeg" 
                                       class="block w-full text-sm text-gray-500
                                       file:mr-4 file:py-2 file:px-4
                                       file:rounded-md file:border-0
                                       file:text-sm file:font-semibold
                                       file:bg-blue-50 file:text-blue-700
                                       hover:file:bg-blue-100"
                                       >
                            </div>
                        </div>
                        <p class="text-xs text-gray-500">JPEG only (Max 2MB)</p>
                        @if($existingDocs->has('passport_photo'))
                            <p class="text-xs text-green-600">Existing file saved. Upload again to replace it.</p>
                        @endif
                        @error('passport_photo')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <div class="flex gap-3">
                        <button type="submit" name="action" value="save"
                                class="w-full bg-amber-500 hover:bg-amber-600 text-white font-medium py-3 px-4 rounded-md transition duration-150 flex items-center justify-center">
                            <i class="fas fa-save mr-2"></i>
                            Save & Continue Later
                        </button>
                        <button type="submit" name="action" value="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-md transition duration-150 flex items-center justify-center">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Submit All Documents
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Requirements Info -->
        <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
            <h3 class="text-sm font-medium text-blue-800 mb-3 flex items-center">
                <i class="fas fa-info-circle mr-2"></i>
                Submission Requirements
            </h3>
            <ul class="text-sm text-blue-700 space-y-2 list-disc pl-5">
                <li>All documents must be clear, legible, and valid</li>
                <li>File size should not exceed 5MB per document (2MB for photo)</li>
                <li>Ensure your name and registration number are visible on documents</li>
                <li>CV must include two referees with contact details (one must be academic staff)</li>
                <li>Medical report must be current and from University Hospital</li>
                <li>Passport photo must be professional (plain background, recent)</li>
            </ul>
        </div>
    </div>
</body>
</html>
@else
<script>
	window.location.href = "{{ route('/normination-landing-page') }}";
</script>
@endauth
