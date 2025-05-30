<!DOCTYPE html>
<html>
<head>
<link rel="shortcut icon" type="x-icon" href="logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Logout Confirmation</title>
    <style>
        @import url(//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css);
        .fa-2x {
font-size: 2em;
}
.fa {
position: relative;
display: table-cell;
width: 60px;
height: 36px;
text-align: center;
vertical-align: middle;
font-size:20px;
}


.main-menu:hover,nav.main-menu.expanded {
width:250px;
overflow:visible;
}

.main-menu {
background:#222831;
border-right:1px solid #e5e5e5;
position:fixed;
top:0;
bottom:0;
height:100%;
left:0;
width:60px;
overflow:hidden;
-webkit-transition:width .05s linear;
transition:width .05s linear;
-webkit-transform:translateZ(0) scale(1,1);
z-index:1000;
font-family: 'Roboto', sans-serif;
}

.main-menu>ul {
margin:50px 0;

}

.main-menu li {
    margin-bottom: 5px;
position:relative;
display:block;
width:250px;

border-radius: 5px;
}

.main-menu li>a {
position:relative;
display:table;
border-collapse:collapse;
border-spacing:0;
color:#ffffff;
 font-family: arial;
font-size: 14px;
text-decoration:none;
-webkit-transform:translateZ(0) scale(1,1);
-webkit-transition:all .1s linear;
transition:all .1s linear;
  
}

.main-menu .nav-icon {
position:relative;
display:table-cell;
width:60px;
height:36px;
text-align:center;
vertical-align:middle;
font-size:18px;
}

.main-menu .nav-text {
position:relative;
display:table-cell;
vertical-align:middle;
width:190px;
  font-family: 'Roboto', sans-serif;
}

.main-menu>ul.logout {
position:absolute;
left:0;
bottom:0;
}

.no-touch .scrollable.hover {
overflow-y:hidden;
}

.no-touch .scrollable.hover:hover {
overflow-y:auto;
overflow:visible;
}

a:hover,a:focus {
text-decoration:none;
}

nav {
-webkit-user-select:none;
-moz-user-select:none;
-ms-user-select:none;
-o-user-select:none;
user-select:none;
}

nav ul,nav li {
outline:0;
margin:0;
padding:0;
}
.main-menu li:hover>a,nav.main-menu li.active>a,.dropdown-menu>li>a:hover,.dropdown-menu>li>a:focus,.dropdown-menu>.active>a,.dropdown-menu>.active>a:hover,.dropdown-menu>.active>a:focus,.no-touch .dashboard-page nav.dashboard-menu ul li:hover a,.dashboard-page nav.dashboard-menu ul li.active a {
color:#fff;
background-color:#00adb5;
}
.area {
float: left;
background: #e2e2e2;
width: 100%;
height: 100%;
}

/* Add this CSS code to your existing stylesheet */
.subnav.active {
    display: block;
}

.subnav {
    display: none;
    position: absolute;
    top: calc(100% + 5px);
    left: 0;
    background-color: #222831;
    width: 230px;
    z-index: 1001;
}



.main-menu .has-subnav .subnav li {
    display: block;
    width: 100%;
}

.main-menu .has-subnav .subnav li a {
    color: #ffffff;
    display: block;
    padding: 10px;
    text-decoration: none;
    transition: background-color 0.3s ease;
}

.main-menu .has-subnav .subnav li a:hover {
    background-color: #00adb5;
    border-radius: 10px;
}

/* Add this CSS code to your existing stylesheet */
.subnav li a {
    background-color: #222831; /* Background color for submenu buttons */
    color: #fff; /* Text color for submenu buttons */
    display: block;
    padding: 10px;
    margin-left: 60px;
    text-decoration: none;
    transition: background-color 0.3s ease;
}

.subnav li a:hover {
    background-color: #ffffff; /* Background color on hover */
}


            /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
            font-family:'Roboto',sans-serif;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 400px;
            text-align: center;
            border-radius:10px;
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.5);
        }

        /* Button styles */
        .btn {
            padding: 10px 20px;
            margin: 5px;
            cursor: pointer;
            transition: box-shadow 0.3s ease; 
        }

        .btn-yes {
            background-color: #f44336;
            color: white;
            border: none;
            border-radius:10px;
        }

        .btn-no {
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius:10px;
        }
        .btn-yes:hover {
            box-shadow: 0 0 10px #f44336; /* Add glow effect */
        }
        .btn-no:hover {
            box-shadow: 0 0 10px #4CAF50; /* Red glow effect */
        }
    </style>
</head>
<body>
<div class="area"></div>
<nav class="main-menu">
    <ul>
        <li>
            <a href="main.php">
                <i class="fa fa-home fa-2x"></i>
                <span class="nav-text">Home</span>
            </a>
        </li>
        <li class="has-subnav booking-container" style="position: relative; ">
            <a href="booking.php" class="booking-link">
                <i class="fa fa-ticket fa-2x"></i>
                <span class="nav-text">Booking</span>
            </a>
        </li>
        <li class="has-subnav">
            <a class="toggle-submenu">
                <i class="fa fa-film fa-2x"></i>
                <span class="nav-text">Movie Section<span class="arrow">&#x21B4;</span></span>
            </a>
            <ul class="subnav">
              <li><a href="add_movies.php"><i class="fa fa-plus-circle"></i> <span class="nav-text">Add Movies</span></a></li>
              <li><a href="del_movies.php"><i class="fa fa-minus-square"></i> <span class="nav-text">Delete Movies</span></a></li>
              <li><a href="sched.php"><i class="fa fa-pencil"></i> <span class="nav-text">Edit Movies</span></a></li>
            </ul>
        </li>
        <li class="has-subnav" style="position: absolute; bottom: 10px; left:0px;">
            <a href="logout.php">
                <i class="fa fa-power-off fa-2x"></i>
                <span class="nav-text">Logout</span>
            </a>
        </li>
    </ul>
</nav>

<div id="myModal" class="modal">
    <div class="modal-content">
        <p>Do you want to log out?</p>
        <button class="btn btn-yes" onclick="logout()">Yes</button>
        <button class="btn btn-no" onclick="cancelLogout()">No</button>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var toggleButton = document.querySelector('.toggle-submenu');
        var subMenu = document.querySelector('.subnav');
        var bookingContainer = document.querySelector('.booking-container');

        toggleButton.addEventListener('click', function() {
            subMenu.classList.toggle('active');
        });
    });
</script>
<script>
    // Get the modal
    var modal = document.getElementById("myModal");

    // Function to display the modal
    function confirmLogout() {
        modal.style.display = "block";
    }

    // Function to logout
    function logout() {
        window.location.href = "index.php"; // Redirect to index.php
    }

    // Function to cancel logout
    function cancelLogout() {
        window.location.href = "main.php"; // Redirect to main.php
    }

    // Close the modal when user clicks outside of it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    // Display the modal when the page is loaded
    window.onload = function() {
        confirmLogout();
    }
</script>

</body>
</html>
