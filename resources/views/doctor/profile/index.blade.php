@include('layouts.header')
<body class="bg-gray-50 dark:bg-gray-900 font-inter">
  <section class="pt-24 pb-16 min-h-screen">
    <div class="container mx-auto px-4">
      <div class="flex flex-wrap">
        <div class="w-full lg:w-1/4 mb-4">
          @include('layouts.doctor_navbar')
        </div>
        <div class="w-full lg:w-3/4">
          <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 border border-gray-200/50 dark:border-gray-700/50">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100 mb-4">My Profile</h1>
            <div class="border-b border-gray-200 dark:border-gray-700 mb-6">
              <nav class="flex space-x-8">
                <button class="tab-button active pb-4 text-sm font-medium text-blue-600 dark:text-blue-400 border-b-2 border-blue-500 dark:border-blue-400" data-tab="basic">
                  <i class="fas fa-user mr-2"></i>Basic Information
                </button>
                <button class="tab-button pb-4 text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 hover:border-gray-300 dark:hover:border-gray-600 border-b-2 border-transparent" data-tab="professional">
                  <i class="fas fa-user-md mr-2"></i>Professional Information
                </button>
                <button class="tab-button pb-4 text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 hover:border-gray-300 dark:hover:border-gray-600 border-b-2 border-transparent" data-tab="working">
                  <i class="fas fa-clock mr-2"></i>Working Hours
                </button>
                <button class="tab-button pb-4 text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 hover:border-gray-300 dark:hover:border-gray-600 border-b-2 border-transparent" data-tab="image">
                  <i class="fas fa-camera mr-2"></i>Profile Image
                </button>
                <button class="tab-button pb-4 text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 hover:border-gray-300 dark:hover:border-gray-600 border-b-2 border-transparent" data-tab="security">
                  <i class="fas fa-lock mr-2"></i>Security
                </button>
              </nav>
            </div>
            <div>
              <!-- Basic Information Tab -->
              <div id="basic-tab" class="tab-content">
                <form id="basic-info-form">
                  @csrf
                  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                      <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Full Name</label>
                      <input type="text" id="name" name="name" value="{{ $user->name }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                      <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email Address</label>
                      <input type="email" id="email" name="email" value="{{ $user->email }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                      <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Phone Number</label>
                      <input type="tel" id="phone" name="phone" value="{{ $user->phone }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                      <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Address</label>
                      <textarea id="address" name="address" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ $user->address }}</textarea>
                    </div>
                    <div class="md:col-span-2">
                      <label for="bio" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Bio</label>
                      <textarea id="bio" name="bio" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ $user->bio }}</textarea>
                    </div>
                  </div>
                  <div class="mt-6">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                      <i class="fas fa-save mr-2"></i>Save Changes
                    </button>
                  </div>
                </form>
              </div>
              <!-- Professional Information Tab -->
              <div id="professional-tab" class="tab-content hidden">
                <form id="professional-info-form">
                  @csrf
                  <div class="space-y-6">
                    <div>
                      <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Specializations</label>
                      <div id="specializations-container" class="space-y-2">
                        @foreach($doctor->specializations ?? [] as $spec)
                        <input type="text" name="specializations[]" value="{{ $spec }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @endforeach
                      </div>
                      <button type="button" id="add-spec-btn" class="mt-2 text-sm text-blue-600 hover:underline">+ Add Specialization</button>
                    </div>
                    <div>
                      <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Qualifications</label>
                      <div id="qualifications-container" class="space-y-2">
                        @foreach($doctor->qualifications ?? [] as $qual)
                        <input type="text" name="qualifications[]" value="{{ $qual }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @endforeach
                      </div>
                      <button type="button" id="add-qual-btn" class="mt-2 text-sm text-blue-600 hover:underline">+ Add Qualification</button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                      <div>
                        <label for="experience_years" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Years of Experience</label>
                        <input type="number" id="experience_years" name="experience_years" value="{{ $doctor->experience_years }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                      </div>
                      <div>
                        <label for="license_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">License Number</label>
                        <input type="text" id="license_number" name="license_number" value="{{ $doctor->license_number }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                      </div>
                    </div>
                    <div>
                      <label for="consultation_fee" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Consultation Fee</label>
                      <input type="number" step="0.01" id="consultation_fee" name="consultation_fee" value="{{ $doctor->consultation_fee }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                      <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Languages</label>
                      <div id="languages-container" class="space-y-2">
                        @foreach($doctor->languages ?? [] as $lang)
                        <input type="text" name="languages[]" value="{{ $lang }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @endforeach
                      </div>
                      <button type="button" id="add-lang-btn" class="mt-2 text-sm text-blue-600 hover:underline">+ Add Language</button>
                    </div>
                  </div>
                  <div class="mt-6">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                      <i class="fas fa-save mr-2"></i>Save Professional Information
                    </button>
                  </div>
                </form>
              </div>
              <!-- Working Hours Tab -->
              <div id="working-tab" class="tab-content hidden">
                <form id="working-hours-form">
                  @csrf
                  <div>
                    <label for="working_hours" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Weekly Schedule (JSON)</label>
                    <textarea id="working_hours" name="working_hours" rows="6" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ json_encode($doctor->working_hours) }}</textarea>
                  </div>
                  <div class="mt-6">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                      <i class="fas fa-save mr-2"></i>Save Working Hours
                    </button>
                  </div>
                </form>
              </div>
              <!-- Profile Image Tab -->
              <div id="image-tab" class="tab-content hidden">
                <div class="text-center mb-6">
                  <div class="relative inline-block">
                    <img id="profile-image" src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : asset('assets/images/default-avatar.png') }}" alt="Profile Image" class="w-32 h-32 rounded-full object-cover border-4 border-gray-200 dark:border-gray-700">
                    <button id="change-image-btn" class="absolute bottom-0 right-0 bg-blue-600 text-white rounded-full p-2 hover:bg-blue-700">
                      <i class="fas fa-camera text-sm"></i>
                    </button>
                  </div>
                  <input type="file" id="profile-image-input" accept="image/*" class="hidden">
                  <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Click the camera to upload a new profile image</p>
                </div>
              </div>
              <!-- Security Tab -->
              <div id="security-tab" class="tab-content hidden">
                <form id="password-form">
                  @csrf
                  <div class="space-y-6 max-w-md">
                    <div>
                      <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Current Password</label>
                      <input type="password" id="current_password" name="current_password" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                      <label for="new_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">New Password</label>
                      <input type="password" id="new_password" name="new_password" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                      <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Confirm New Password</label>
                      <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                  </div>
                  <div class="mt-6">
                    <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                      <i class="fas fa-key mr-2"></i>Update Password
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <div id="message-container" class="fixed top-4 right-4 z-50"></div>
  <script>
  document.addEventListener('DOMContentLoaded', function() {
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content');
    tabButtons.forEach(button => {
      button.addEventListener('click', () => {
        const tab = button.getAttribute('data-tab');
        tabButtons.forEach(btn => {
          btn.classList.remove('active','border-blue-500','text-blue-600','dark:text-blue-400');
          btn.classList.add('border-transparent','text-gray-500','dark:text-gray-400');
        });
        button.classList.add('active','border-blue-500','text-blue-600','dark:border-blue-400','dark:text-blue-400');
        button.classList.remove('border-transparent','text-gray-500','dark:text-gray-400');
        tabContents.forEach(content => content.classList.add('hidden'));
        document.getElementById(tab + '-tab').classList.remove('hidden');
      });
    });
    document.getElementById('add-spec-btn').addEventListener('click', () => {
      const container = document.getElementById('specializations-container');
      const input = document.createElement('input');
      input.type = 'text';
      input.name = 'specializations[]';
      input.className = 'w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500';
      container.appendChild(input);
    });
    document.getElementById('add-qual-btn').addEventListener('click', () => {
      const container = document.getElementById('qualifications-container');
      const input = document.createElement('input');
      input.type = 'text';
      input.name = 'qualifications[]';
      input.className = 'w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500';
      container.appendChild(input);
    });
    document.getElementById('add-lang-btn').addEventListener('click', () => {
      const container = document.getElementById('languages-container');
      const input = document.createElement('input');
      input.type = 'text';
      input.name = 'languages[]';
      input.className = 'w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500';
      container.appendChild(input);
    });
    document.getElementById('change-image-btn').addEventListener('click', () => {
      document.getElementById('profile-image-input').click();
    });
    document.getElementById('profile-image-input').addEventListener('change', function(e) {
      if(e.target.files && e.target.files[0]) {
        const formData = new FormData();
        formData.append('profile_image', e.target.files[0]);
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        fetch('/doctor/profile/profile-image', {
          method: 'POST',
          body: formData
        })
        .then(res => res.json())
        .then(data => {
          if(data.success) {
            document.getElementById('profile-image').src = data.image_url;
            showMessage(data.message, 'success');
          } else {
            showMessage(data.message || 'Failed to upload image', 'error');
          }
        })
        .catch(() => showMessage('Failed to upload image', 'error'));
      }
    });
    function submitForm(url, formData, successMsg) {
      fetch(url, {
        method: 'POST',
        body: formData
      })
      .then(res => res.json())
      .then(data => {
        if(data.success) showMessage(successMsg, 'success');
        else showMessage(data.message || 'An error occurred', 'error');
      })
      .catch(() => showMessage('An error occurred', 'error'));
    }
    document.getElementById('basic-info-form').addEventListener('submit', function(e) {
      e.preventDefault();
      submitForm('/doctor/profile/basic-info', new FormData(this), 'Basic information updated successfully!');
    });
    document.getElementById('professional-info-form').addEventListener('submit', function(e) {
      e.preventDefault();
      submitForm('/doctor/profile/doctor-info', new FormData(this), 'Professional information updated successfully!');
    });
    document.getElementById('working-hours-form').addEventListener('submit', function(e) {
      e.preventDefault();
      submitForm('/doctor/profile/availability', new FormData(this), 'Working hours updated successfully!');
    });
    document.getElementById('password-form').addEventListener('submit', function(e) {
      e.preventDefault();
      submitForm('/doctor/profile/password', new FormData(this), 'Password updated successfully!');
    });
    function showMessage(message, type) {
      const container = document.getElementById('message-container');
      const div = document.createElement('div');
      div.className = `p-4 rounded-lg shadow-lg mb-4 ${type==='success'?'bg-green-500':'bg-red-500'} text-white`;
      div.innerHTML = `<div class="flex items-center justify-between"><span>${message}</span><button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white hover:text-gray-200"><i class="fas fa-times"></i></button></div>`;
      container.appendChild(div);
      setTimeout(() => { if(div.parentElement) div.remove(); }, 5000);
    }
  });
  </script>
</body>
</html>
