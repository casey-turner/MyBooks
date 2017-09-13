<div class="main-wrapper">
    <div class="container">
        <?php
        if ( isset($_SESSION['notification']) ) { ?>
            <div class="notification">
                <p><?php echo $_SESSION['notification']; ?></p>
            </div>
        <?php
            unset($_SESSION['notification']);
        }
        ?>
        <div class="row">
            <?php
            if (!empty($books)) {
                $count = 0;
                foreach ($books as $book) {
                    foreach ($authors as $author) {
                        if ($book['authorID'] == $author['authorID']) {
                            $authorName = $author['firstName'].' '.$author['lastName'];
                        }
                    }
                    if ($book['imageURL'] != '') {
                        $image = $book['imageURL'];
                    } else {
                        $image = 'view/images/default.png';
                    }
                    ?>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="book-item">
                            <img src="<?php echo $image; ?>" alt="<?php echo $book['bookTitle'];?> Cover">
                            <p><?php echo $book['bookTitle']; ?></br>
                            <i><?php echo $authorName; ?></i></p>
                            <a class="btn-square" href="?controller=books&action=viewbook&bookid=<?php echo $book['bookID']; ?>">View</a>
                            <a class="btn-square" href="?controller=books&action=editbook&bookid=<?php echo $book['bookID']; ?>">Edit</a>
                            <a class="btn-square" href="?controller=books&action=deletebook&bookid=<?php echo $book['bookID']; ?>">Delete</a>
                        </div>
                    </div>
                    <?php
                    $count++;
                }
            }
            ?>
        </div>
    </div>
</div>
