<?php 

if (! empty($user) && is_array($user)) {

    foreach ($user as $singleUser){
?>

    <article class="container">
        <h3><?= esc($singleUser['userName']) ?></h3>

        <section class="main">

        <pre class="container">
<?php
            foreach ($singleUser as $key=>$value) {
                print_r($key . ": " . $value . "\n");
            }
?>
        </pre>
        
        </section>

        <p><a class="container" href="/user/<?= esc($singleUser['userName'], 'url') ?>">
            <button id='search' type='submit' class='btn btn-info'>
                Show single View
            </button>
        </a></p>
    </article>
<?php 
    }

} else {
?>

<h3>No Users</h3>

<p>Unable to find any users.</p>

<?php 
} ?>