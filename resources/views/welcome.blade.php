<div class="login-form">
    <h1>Login</h1>
    <form id="login-form" method="POST" action="{{ route('login') }}">
        @csrf
        <div>
            <label for="login">Usuário:</label>
            <input type="text" id="login" name="login" value="{{ old('login') }}" required autofocus />
        </div>
        <div>
            <label for="password">Senha:</label>
            <input type="password" id="password" name="password" required />
        </div>
        <button type="submit">Entrar</button>
    </form>
</div>
<link rel="stylesheet" href="{{ asset('css/login.css') }}">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    $(document).ready(function() {
        $('#login-form').submit(function(e) {
            e.preventDefault(); // Impede o envio tradicional do formulário

            var form = $(this);
            var url = form.attr('action');
            var data = form.serialize();

            $.ajax({
                type: 'POST',
                url: url,
                data: data,
                success: function(res) {
                    var message = res.message;
                    toastr.success(message);
                    window.location.href = "{{ route('inicio') }}";
                },
                error: function(res) {
                    // Exibir mensagem de erro caso a autenticação falhe
                    var message = res.message;
                    toastr.error(message);
                }
            });
        });
    });
</script>
