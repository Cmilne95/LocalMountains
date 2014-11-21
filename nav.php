    <nav>
        <ol>
            <?php
            if ($path_parts['filename'] == "index") {
                print '<li class="activePage">Home</li>';
            } else {
                print '<li><a href="index.php">Home</a></li>';
            }

            if ($path_parts['filename'] == "resorts_map") {
                print '<li class="activePage">map</li>';
            } else {
                print '<li><a href="resorts_map.php">map</a></li>';
            }

            if ($path_parts['filename'] == "Summaries") {
                print '<li class="activePage">Summaries</li>';
            } else {
                print '<li><a href="summaries.php">Summaries</a></li>';
            }

            if ($path_parts['filename'] == "survey") {
                print '<li class="activePage">Survey</li>';
            } else {
                print '<li><a href="survey.php">Survey</a></li>';
            }

            if ($path_parts['filename'] == "about") {
                print '<li class="activePage">About Us</li>';
            } else {
                print '<li><a href="about.php">About Us</a></li>';
            }
            ?>
        </ol>
    </nav>