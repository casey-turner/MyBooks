<div class="main-wrapper">
    <div class="container">
        <div class="row">
            <?php
            $books = selectData('book', array('order_by'=> 'BookID'));
            $authors = selectData('author', array('select'=> ' AuthorID, Name, Surname'));
            if (!empty($books)) {
                $count = 0;
                foreach ($books as $book) {
                    foreach ($authors as $author) {
                        if ($book['AuthorID'] == $author['AuthorID']) {
                            $authorName = $author['Name'].' '.$author['Surname'];
                        }
                    }
                    if ($book['ImageURL'] != '') {
                        $image = $book['ImageURL'];
                    } else {
                        $image = 'http://localhost/mybooks/view/images/default.png';
                    }
                    ?>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="book-item">
                            <img src="<?php echo $image; ?>" alt="<?php echo $book['BookTitle'];?> Cover">
                            <p><?php echo $book['BookTitle']; ?></br>
                            <i><?php echo $authorName; ?></i></p>
                            <a class="btn-square" href="?controller=books&action=viewbook&bookid=<?php echo $book['BookID']; ?>">View</a>
                            <a class="btn-square" href="?controller=books&action=editbook&bookid=<?php echo $book['BookID']; ?>">Edit</a>
                            <a class="btn-square" href="?view=deletebook&bookid=<?php echo $book['BookID']; ?>">Delete</a>
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
