<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Generate Short URL</title>
</head>

<body>

    <h1>Generate Short URL</h1>

    {{-- @csrf generates a hidden security token in the form.
         Why? Laravel rejects any POST request without this token
         to protect against CSRF (Cross-Site Request Forgery) attacks. --}}

    <form method="POST" action="{{ route('urls.store') }}">
        @csrf

        <label for="long_url">Long URL:</label><br>
        <input type="url" id="long_url" name="long_url" value="{{ old('long_url') }}"
            placeholder="https://example.com/very/long/url" style="width: 400px;">
        <br><br>

        {{-- Show validation error if long_url is invalid --}}
        @error('long_url')
            <p style="color: red;">{{ $message }}</p>
        @enderror

        <button type="submit">Generate</button>
    </form>

    <br>
    <a href="{{ route('dashboard') }}">← Back to Dashboard</a>

</body>

</html>
