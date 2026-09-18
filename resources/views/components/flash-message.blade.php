@if (session('success'))
    <div class="alert alert-success flash-message" role="alert">
        {{ session('success') }}
    </div>

    @push('scripts')
        <script>
            setTimeout(function () {
                $('.flash-message').fadeOut(500);
            }, 5000);
        </script>
    @endpush
@endif