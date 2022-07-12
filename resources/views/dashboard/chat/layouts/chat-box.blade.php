<div id="chat_box" class="col d-none">
    <div class="card m-b-30">
        <div class="card-body p-0">
            <div class="row chat-box">

                <div class="col pr-0 chat-right-aside">

                    <div class="chat">

                        <div class="chat-header clearfix"><img class="rounded-circle user_image"
                                src="{{ asset('vendor/dashboard/image/avatar.png') }}" alt=""
                                data-original-title="" title="">
                            <div class="about">
                                <div class="name chat-user active"></div>

                                <div class="status last_seen"></div>
                            </div>

                            <div class="float-right">
                                <a class="close-chat" href="javascript:void(0)">
                                    <i class="uil uil-times"></i>
                                </a>
                            </div>
                        </div>

                        <div class="chat-history chat-area chat-msg-box custom-scrollbar">

                        </div>

                        <div class="chat-message clearfix">
                            <div class="row">
                                <div class="col d-flex">
                                    <div class="input-group text-box">
                                        <input autofocus class="form-control chat_input input-txt-bx" id="message-to-send"
                                            type="text" name="message-to-send" placeholder="Type a message......"
                                            data-original-title="" title="">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary btn-chat" type="button" data-to-user="">
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <input type="hidden" id="my_id" value="" />
    <input type="hidden" id="to_user_id" value="" />
</div>
