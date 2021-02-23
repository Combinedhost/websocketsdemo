@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
@endsection

@section('content')

    <section class="messenger">
        <header class="messenger-header">
            <div class="messenger-header-title">
                <i class="fas fa-comment-alt"></i> Laravel Websockets Demo - Jon Pro
            </div>
            <div class="messenger-header-options">
                <span><i class="fas fa-cog"></i></span>
            </div>
        </header>

        <main class="messenger-chat">
        </main>

        <form class="messenger-inputarea">
            <input type="text" class="messenger-input" placeholder="Enter your message...">
            <button type="submit" class="messenger-send-btn">Send</button>
        </form>
    </section>
@endsection

@push('scripts')
    <script>

        const messengerForm = get(".messenger-inputarea");
        const messengerInput = get(".messenger-input");
        const messengerChat = get(".messenger-chat");

        messengerForm.addEventListener("submit", event => {
            event.preventDefault();
            var request = $.ajax({
                url: "{{ url('/message') }}",
                type: "POST",
                data: {
                    message : messengerInput.value,
                    _token: "{{csrf_token()}}"
                },
                success: function () {
                    messengerInput.value = '';
                }
            });
        });

        function appendMessage(name, img, side, text) {
               const msgHTML = `
                <div class="msg ${side}-msg">
                  <div class="msg-img" style="background-image: url(${img})"></div>

                  <div class="msg-bubble">
                    <div class="msg-info">
                      <div class="msg-info-name">${name}</div>
                      <div class="msg-info-time">${formatDate(new Date())}</div>
                    </div>

                    <div class="msg-text">${text}</div>
                  </div>
                </div>
              `;

            messengerChat.insertAdjacentHTML("beforeend", msgHTML);
            messengerChat.scrollTop += 500;
        }

        function get(selector, root = document) {
            return root.querySelector(selector);
        }

        function formatDate(date) {
            const h = "0" + date.getHours();
            const m = "0" + date.getMinutes();

            return `${h.slice(-2)}:${m.slice(-2)}`;
        }

        window.Echo.channel('chat-room').listen('.App\\Events\\NewChatMessage', (e) => {
            var direction = ("{{auth()->id()}}" == e.user.id) ? "right" : "left";
            appendMessage(e.user.name, 'https://image.flaticon.com/icons/svg/145/145867.svg' , direction, e.message);
        });

    </script>

@endpush


