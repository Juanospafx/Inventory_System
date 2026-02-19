<?php
$title = ConfigurationData::getByPreffix("general_main_title")->val;
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!Session::issetUID()) {
    header("Location: login.php");
    exit;
}
$user_id = Session::getUID();
$roles = Session::getRoles();
$is_admin = Session::hasRole("Administrador");
?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Brigtronix - Online Catalog System</title>

    <link rel="stylesheet" type="text/css" href="res/lib/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="res/lib/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="res/btn-label.css">
    <script src="res/lib/jquery/jquery.min.js"></script>
    <script src="res/bootstrap-rating.min.js"></script>

    <style>
        #suggestions {
            position: absolute;
            z-index: 9999;
            background: #fff;
            border: 1px solid #ccc;
            max-height: 300px;
            overflow-y: auto;
            box-shadow: 0px 2px 8px rgba(0,0,0,0.2);
            border-radius: 4px;
            width: 500px;
            display: none;
        }
        #suggestions div {
            display: flex;
            align-items: center;
            padding: 8px;
            cursor: pointer;
            border-bottom: 1px solid #eee;
        }
        #suggestions div:hover {
            background-color: #f0f0f0;
        }
        #suggestions img {
            width: 40px;
            height: 40px;
            object-fit: cover;
            margin-right: 10px;
            border-radius: 4px;
        }
    </style>
</head>
<body>

<div id="suggestions"></div>

<section>
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-xs-5">
                <br><h1><?php echo htmlspecialchars($title); ?></h1>
            </div>
            <div class="col-md-7 col-xs-5">
                <br><br>
                <form class="form-horizontal" role="form" method="GET" action="index.php">
                    <div class="input-group" style="position:relative;">
                        <input type="hidden" name="view" value="products">
                        <input type="hidden" name="act" value="search">
                        <input type="text" name="q" placeholder="Search for publications..." class="form-control">
                        <span class="input-group-btn">
                            <button class="btn btn-primary" type="submit">
                                &nbsp;<i class="fa fa-search"></i>&nbsp;
                            </button>
                        </span>
                    </div>
                </form>
                <br><br>
            </div>
        </div>
    </div>
</section>

<nav class="navbar navbar-default navbar-static-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>

        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav">
                <li><a href="./"><i class="fa fa-home"></i> Home</a></li>
                <?php $cats = CategoryData::getPublics(); ?>
                <?php if(count($cats) > 0): ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-th-list"></i> Categories<b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <?php foreach ($cats as $cat): ?>
                        <li>
                            <a href="index.php?view=products&cat=<?php echo htmlspecialchars($cat->short_name); ?>">
                                <?php echo htmlspecialchars($cat->name); ?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </li>
                <?php endif; ?>
                <li>
                    <a href="index.php?view=cart">
                        <i class="fa fa-shopping-cart"></i> Cart 
                        <span class="badge">
                            <?php echo isset($_SESSION["cart"]) ? count($_SESSION["cart"]) : 0; ?>
                        </span>
                    </a>
                </li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-user"></i> &nbsp; <?php echo htmlspecialchars(UserData::getById($user_id)->name); ?><b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="./"><i class="fa fa-home"></i> Home</a></li>
                        <li><a href="logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<?php View::load("home"); ?>
<br><br><br>

<section>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <hr>
                <p><b>BrigCat</b> v1.2 &copy; 2025</p>
                <ul class="list-inline">
                    <li>
                        <p class="text-muted">
                            Powered by <a href="https://brightronix.com/wp/" target="_blank">Brightronix</a>
                        </p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
<br>

<script src="res/lib/bootstrap/js/bootstrap.min.js"></script>
<script>
    $(".tip").tooltip();
</script>

<script>
$(document).ready(function() {
    var $input = $("input[name='q']");
    var $suggestions = $("#suggestions");

    if ($input.length === 0) return;

    var typingTimer;
    var doneTypingInterval = 300;

    function positionSuggestions() {
        var offset = $input.offset();
        $suggestions.css({
            top: offset.top + $input.outerHeight(),
            left: offset.left,
            width: $input.outerWidth()
        });
    }

    $input.on("keyup", function () {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(doneTyping, doneTypingInterval);
        positionSuggestions();
    });

    $input.on("keydown", function () {
        clearTimeout(typingTimer);
    });

    function doneTyping() {
        var q = $input.val();
        if (q.length >= 2) {
            $.get("api/v1/index.php?route=search/suggest", { q: q }, function (data) {
                $suggestions.empty().show();
                if (data.length === 0) {
                    $suggestions.html("<div style='padding:8px;'>No results</div>");
                    return;
                }
                data.forEach(function (item) {
                    $suggestions.append(
                        $("<div></div>").on("click", function () {
                            window.location.href = item.url;
                        }).append(
                            $("<img>").attr("src", item.image)
                        ).append(
                            $("<span></span>").text(item.name)
                        )
                    );
                });
            });
        } else {
            $suggestions.hide();
        }
    }

    $(document).on("click", function (e) {
        if (!$(e.target).closest($input).length && !$(e.target).closest($suggestions).length) {
            $suggestions.hide();
        }
    });
});
</script>

</body>
</html>
