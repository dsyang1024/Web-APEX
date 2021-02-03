<html>
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.js"></script>
        <style type="text/css">
        #overlay {
        background: #ffffff;
        color: #666666;
        position: fixed;
        height: 100%;
        width: 100%;
        z-index: 5000;
        top: 0;
        left: 0;
        float: left;
        text-align: center;
        padding-top: 25%;
        opacity: .80;
        }
        button {
        margin: 40px;
        padding: 5px 20px;
        cursor: pointer;
        }
        .spinner {
            margin: 0 auto;
            height: 64px;
            width: 64px;
            animation: rotate 0.8s infinite linear;
            border: 5px solid firebrick;
            border-right-color: transparent;
            border-radius: 50%;
        }
        @keyframes rotate {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }
        </style>

    </head>
    <body>
        <div class="spinner"></div>
        <br/>
        Loading...
        </div>   
    </body>
</html>

