<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Canvas Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

    <div class="bg-white shadow-lg rounded-lg p-8 max-w-md w-full">
        <h2 class="text-2xl font-bold mb-6 text-center">Login with Canvas</h2>

        <form action="{{ route('canvas.login.redirect') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="canvas_domain" class="block text-sm font-medium text-gray-700 mb-1">
                    Canvas Domain
                </label>
                <input type="text" name="canvas_domain" id="canvas_domain" placeholder="canvas.instructure.com"
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>

            <button type="submit"
                    class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">
                Sign in with Canvas
            </button>
        </form>
    </div>

</body>
</html>
