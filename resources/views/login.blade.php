<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - Client Portal</title>
  <link href="/css/tailwind.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
  <div class="bg-white p-6 rounded shadow-md w-full max-w-sm">
    <h1 class="text-xl font-bold mb-4 text-blue-600">Login Form</h1>
    @if(session('error'))
      <p class="text-red-500 text-sm">{{ session('error') }}</p>
    @endif
    <form method="POST" action="/login">
      @csrf
      <label class="block mb-2 text-sm text-gray-700">Nomor HP</label>
      <input type="text" name="username" required class="w-full px-3 py-2 border rounded mb-4">
      
      <label class="block mb-2 text-sm text-gray-700">Password</label>
      <input type="password" name="password" required class="w-full px-3 py-2 border rounded mb-4">
      
      <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 rounded">
        Login
      </button>
    </form>
  </div>
</body>
</html>
