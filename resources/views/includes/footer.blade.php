
    @livewireScripts()
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/jquery-3.5.1.js') }}" ></script>
    <script src="{{ asset('js/bootstrap.4.5.2.js') }}" defer></script>
     <script>

        
    window.addEventListener('livewire:load', function() {
        $(".alert-dismissible").fadeTo(2000, 500).slideUp(500, function(){
            $(".alert-dismissible").slideUp(500);
        });
    });
    </script>
