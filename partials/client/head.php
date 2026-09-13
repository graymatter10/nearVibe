    <title>NearVibe</title>
    <style>
        body {
            margin: 0;
            background-color: whitesmoke;
            font-family: Arial;
        }

        #heading {
            height: 60px;
            background-color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 25px;
        }

        #logo {
            color: blue;
        }

        #client {
            background-color: skyblue;
            color: blue;
            padding: 6px 15px;
            border-radius: 20px;
        }

        #layout {
            display: flex;
        }

        #menu {
            background-color: #0d1330;
            height: 100vh;
            width: 30vh;
        }

        #menu button {
            width: calc(100% - 20px);
            margin: 8px 10px;
            padding: 15px 25px;
            background-color: #0d1330;
            border: none;
            border-radius: 10px;
            color: #aaa;
            text-align: left;
            cursor: pointer;
        }

        #menu button:hover {
            background-color: #1c2450;
            color: white;
        }

        #menu button.active {
            background-color: #2947a3;
            color: white;
        }

        #menu button.active:hover {
            background-color: #3a5bc7;
        }

        #middle {
            padding: 20px;
            flex: 1;
            min-width: 0;
        }
    </style>