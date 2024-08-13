<?php
// Include necessary files and database connection
include_once('admin/dbconnect.php');
include_once('layout/functions.php');

try {
    $stmt = $pdo->prepare('SELECT * FROM packages');
    $stmt->execute();
    $packages = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

foreach ($packages as $package) {
    echo '<a href="accommodationDetail.php?id=' . $package['packageId'] . '">';
    echo '<div class="col-md-4 mb-4">';
    echo '<div class="card">';
    echo '<img class="card-img-top" src="admin/assets/img/package/' . $package['packageImg'] . '" alt="Package image">';
    echo '<div class="card-body">';
    echo '<h5 class="card-title">' . $package['packageName'] . '</h5>';
    echo '<p class="card-text package-description">' . shortenText($package['packageDescription'], 50) . '</p>';
    echo '<p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</a>';
}
