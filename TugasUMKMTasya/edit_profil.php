<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .avatar-upload {
            position: relative;
            max-width: 150px;
            margin: 0 auto;
        }
        .avatar-upload .avatar-preview {
            width: 150px;
            height: 150px;
            border-radius: 100%;
            border: 3px solid #e2e8f0;
            transition: all 0.3s;
        }
        .avatar-upload:hover .avatar-preview {
            border-color: #6366f1;
            filter: brightness(0.95);
        }
        .avatar-upload input[type="file"] {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            cursor: pointer;
        }
        .avatar-upload .edit-icon {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background: #6366f1;
            color: white;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-3xl">
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="bg-indigo-600 py-4 px-6">
                    <h1 class="text-xl font-semibold text-white">Edit Profil</h1>
                </div>
                
                <div class="p-6">
                    <div class="text-center mb-8">
                        <div class="avatar-upload">
                            <div class="avatar-preview">
                                <img src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/f70c7f4d-4ae0-480a-a693-280969382fa4.png" alt="Foto profil pengguna dengan latar belakang biru muda mengenakan kemeja formal" id="avatarPreview" class="w-full h-full object-cover rounded-full">
                            </div>
                            <div class="edit-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </div>
                            <input type="file" id="avatarInput" accept="image/*" class="hidden">
                        </div>
                    </div>

                    <form id="profileForm">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="namaDepan" class="block text-sm font-medium text-gray-700 mb-1">Nama Depan</label>
                                <input type="text" id="namaDepan" name="namaDepan" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" value="John">
                            </div>
                            <div>
                                <label for="namaBelakang" class="block text-sm font-medium text-gray-700 mb-1">Nama Belakang</label>
                                <input type="text" id="namaBelakang" name="namaBelakang" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" value="Doe">
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                                <input type="email" id="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" value="john.doe@example.com">
                            </div>
                            <div>
                                <label for="telepon" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                                <input type="tel" id="telepon" name="telepon" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" value="081234567890">
                            </div>
                            <div class="md:col-span-2">
                                <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                                <textarea id="alamat" name="alamat" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">Jl. Contoh No. 123, Jakarta</textarea>
                            </div>
                            <div>
                                <label for="kota" class="block text-sm font-medium text-gray-700 mb-1">Kota</label>
                                <input type="text" id="kota" name="kota" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" value="Jakarta">
                            </div>
                            <div>
                                <label for="provinsi" class="block text-sm font-medium text-gray-700 mb-1">Provinsi</label>
                                <input type="text" id="provinsi" name="provinsi" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" value="DKI Jakarta">
                            </div>
                        </div>

                        <div class="mt-8 border-t border-gray-200 pt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Ubah Password</h3>
                            <div class="grid grid-cols-1 gap-6">
                                <div>
                                    <label for="passwordLama" class="block text-sm font-medium text-gray-700 mb-1">Password Lama</label>
                                    <input type="password" id="passwordLama" name="passwordLama" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                                <div>
                                    <label for="passwordBaru" class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                                    <input type="password" id="passwordBaru" name="passwordBaru" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                                <div>
                                    <label for="konfirmasiPassword" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                                    <input type="password" id="konfirmasiPassword" name="konfirmasiPassword" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 flex justify-end space-x-3">
                            <button type="button" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Batal
                            </button>
                            <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Preview avatar upload
        const avatarInput = document.getElementById('avatarInput');
        const avatarPreview = document.getElementById('avatarPreview');
        
        avatarInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    avatarPreview.src = event.target.result;
                }
                reader.readAsDataURL(file);
            }
        });

        // Form validation
        const profileForm = document.getElementById('profileForm');
        profileForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validate password change
            const oldPassword = document.getElementById('passwordLama').value;
            const newPassword = document.getElementById('passwordBaru').value;
            const confirmPassword = document.getElementById('konfirmasiPassword').value;
            
            if (oldPassword || newPassword || confirmPassword) {
                if (newPassword !== confirmPassword) {
                    alert('Password baru dan konfirmasi password tidak cocok');
                    return;
                }
                
                if (newPassword.length < 8) {
                    alert('Password harus minimal 8 karakter');
                    return;
                }
            }
            
            // Form is valid, proceed with submission
            alert('Profil berhasil diperbarui!');
            // In a real application, you would submit the form data to the server here
            // e.g., using fetch() or AJAX
        });

        // Responsive behavior
        function handleResize() {
            // Add responsive adjustments if needed
        }
        
        window.addEventListener('resize', handleResize);
        handleResize();
    </script>
</body>
</html>

