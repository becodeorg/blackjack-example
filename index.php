<?php
declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require 'code/Card.php';
require 'code/Deck.php';
require 'code/Suit.php';
require 'code/Blackjack.php';
require 'code/Player.php';
require 'code/Dealer.php';

session_start();

if(!isset($_SESSION['blackjack'])) {
    $_SESSION['blackjack'] = new Blackjack();
}
$blackjack = $_SESSION['blackjack'];

if(isset($_POST['action'])) {
    switch($_POST['action']) {
        case 'hit':
            $blackjack->getPlayer()->hit($blackjack->getDeck());
            break;
        case 'stand':
            $blackjack->getDealer()->hit($blackjack->getDeck());
            $blackjack->standOff();
            break;
        case 'surrender':
            $blackjack->getPlayer()->lose();
            break;
        case 'new-game':
            unset($_SESSION['blackjack']);
            header('location: index.php');
            exit;
        default:
            die(sprintf('Something unexpected happened, got unknown action %s', $_POST['action']));
    }
}
$winner = $blackjack->determineWinner();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" type="text/css"
          rel="stylesheet"/>
    <title>Blackjack</title>
    <style>
        .card {
            font-size: 5em;
            display: inline-block;
        }
    </style>
</head>

<body style="background-image: url(img/blackjack.jpg); background-size: cover; background-repeat: repeat;"
      class="text-center text-light">

<header>
    <h1 class="m-5">Get ready for an awesome game of blackjack!</h1>
</header>

<?php if(!empty($winner)):?>
    <h2>The winner is: <?php echo $winner?></h2>
<?php endif;?>

<main class="container">
    <div class="row justify-content-center">
        <div class="col-3">
            <div id="player">
                <h3 class="mb-5">The Table</h3>
                <h5>Player cards</h5>
                <h4 class="bg-light d-inline-block p-3 rounded">
                <?php foreach($blackjack->getPlayer()->getCards() AS $card):?>
                <?php echo $card->getUnicodeCharacter(true);?>
                <?php endforeach;?>
                </h4>
            </div>
            </br>
            <div id="dealer">
                <h5>Dealer cards</h5>
                <h4 class="bg-light d-inline-block p-3 rounded">
                    <?php echo $blackjack->getDealer()->getCards()[0]->getUnicodeCharacter(true);?>
                </h4>
            </div>
        </div>
        <div class="col-3">
            <h3 class="mb-5">The Score</h3>
            <h5>Player: <?php echo $blackjack->getPlayer()->getScore()?></h5>
            <h5>Dealer: <?php echo $blackjack->getDealer()->getScore()?></h5>
            </br>
        </div>
    </div>
    <div class="row justify-content-center m-5">
        <form action="" method="POST">
            <fieldset>
                <?php $disabledButton = !empty($winner) ? 'disabled' : '';?>
                <button type="submit" name="action" value="hit" <?php echo $disabledButton?>>Hit</button>
                <button type="submit" name="action" value="stand" <?php echo $disabledButton?>>Stand</button>
                <button type="submit" name="action" value="surrender" <?php echo $disabledButton?>>Surrender</button>
                <button type="submit" name="action" value="new-game">New game</button>
            </fieldset>
        </form>
    </div>
</main>
</body>
</html>
