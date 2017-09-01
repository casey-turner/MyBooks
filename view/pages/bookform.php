<div class="main-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-8">
                <form id="addBook" class="form-white-bkg" action="" method="post">
                    <legend>Add Book</legend>
                    <div class="tabs">
                        <div id="section-1">
                            <label>Title</label>
                            <input type="text" name="title" value="">
                            <label>Original Title</label>
                            <input type="text" name="originaltitle" value="">
                            <label>Year of Publication</label>
                            <input type="text" name="publication" value="">
                            <label>Genre</label>
                            <input type="text" name="genre" value="">
                            <label>Millions Sold</label>
                            <input type="text" name="sold" value="">
                            <label>Language Written</label>
                            <input type="text" name="language" value="">
                            <div class="formNav">
                                <a id="section1Next" href="#" class="next-btn">Next</a>
                                <div class="clear"></div>
                            </div>
                        </div>
                        <div id="section-2" class="hiddenStep">
                            <div class="selectionFieldGroup">
                                <label>Author</label>
                                <div class="radio">
                                    <label><input type="radio" name="authorSelect" value="existingAuthor">
                                    Existing Author</label>
                                </div>
                                <div class="radio">
                                    <label><input type="radio" name="authorSelect" value="newAuthor">
                                    New Author</label>
                                </div>
                            </div>
                            <div id="existingAuthor">
                                <select class="" name="">
                                    <option value="" disabled selected>Select Author</option>
                                    <?php foreach ($authors as $author) { ?>
                                        <option value="<?php echo $author['authorID']; ?>"><?php echo $author['firstName']." ".$author['lastName']; ?></option>
                                    <?php } ?>


                                </select>
                            </div>
                            <div id="newAuthor">
                                <label>First Name</label>
                                <input type="text" name="firstName" value="">
                                <label>Surname</label>
                                <input type="text" name="lastName" value="">
                                <label>Nationality</label>
                                <input type="text" name="nationality" value="">
                                <label>Birth Year</label>
                                <input type="text" name="birthYear" value="">
                                <label>Death Year</label>
                                <input type="text" name="deathYear" value="">
                            </div>
                            <div class="formNav">
                                <a href="#" id="section2Prev" class="prev-btn">Prev</a>
                                <a href="#" id="section2Next" class="next-btn">Next</a>
                            </div>
                        </div>
                        <div id="section-3" class="hiddenStep">
                            <label>Book Plot</label>
                            <textarea class="form-control" rows="5"></textarea>
                            <label>Plot Source</label>
                            <input type="text" name="plotsource" value="">
                            <label>Book Ranking</label>
                            <input type="text" name="publication" value="">
                            <div class="formNav">
                                <a href="#" id="section3Prev" class="prev-btn">Prev</a></li>
                                <input type="submit" name="submit" value="submit">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-2">
            </div>
        </div>
    </div>
</div>
