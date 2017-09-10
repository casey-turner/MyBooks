<div class="main-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <img src="<?php echo $image; ?>" alt="<?php echo $book['bookTitle'];?> Cover">
            </div>
            <div class="col-md-9">
                <h1 class="headingUnderline"><?php echo $book['bookTitle'] ?></h1>
                <i><p class="author"><?php echo $book['firstName']." ".$book['lastName']; ?></p></i>
                <p><?php echo $plot['plot']; ?></p>
            </div>
        </div>
        <div class="row bookDetails">
            <div class="col-md-6">
                <h3 class="headingUnderline">About the Book</h3>

                <?php if (!empty ($book['originalTitle'])) { ?>
                    <p><strong>Original Title:</strong></br>
                    <?php echo $book['originalTitle']; ?></p>
                <?php } ?>

                <?php if (!empty ($book['yearofPublication'])) { ?>
                    <p><strong>First Published:</strong></br>
                    <?php echo $book['yearofPublication']; ?></p>
                <?php } ?>

                <?php if (!empty ($book['genre'])) { ?>
                    <p><strong>Genre:</strong></br>
                    <?php echo $book['genre']; ?></p>
                <?php } ?>

                <?php if (!empty ($book['millionsSold'])) { ?>
                    <p><strong>Sold:</strong></br>
                    <?php echo $book['millionsSold']; ?> million</p>
                <?php } ?>

                <?php if (!empty ($ranking['rankingScore'])) { ?>
                    <p><strong>Ranking:</strong></br>
                        <?php echo $ranking['rankingScore']; ?></p>
                <?php } ?>
            </div>
            <div class="col-md-6">
                <h3 class="headingUnderline">About the Author</h3>

                <p><strong>Name:</strong></br>
                <?php echo $book['firstName']." ".$book['lastName']; ?></p>


                <?php if (!empty ($book['nationality'])) { ?>
                    <p><strong>Nationality:</strong></br>
                    <?php echo $book['nationality']; ?></p>
                <?php } ?>

                <?php if (!empty ($book['birthYear'])) {?>
                    <p><strong>Born:</strong></br>
                    <?php echo $book['birthYear']; ?></p>
                <?php } ?>

                <?php if (!empty ($book['deathYear'])) { ?>
                    <p><strong>Died:</strong></br>
                    <?php echo $book['deathYear']; ?></p>
                <?php } ?>


            </div>
        </div>
    </div>
</div>
