<div class="main-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-8">
                <form id="addBook" class="form-white-bkg" action="?controller=books&action=<?php echo $action?><?php if ($action == 'editbook') { echo '&bookid='.$book['bookID'];}?>" method="post" data-parsley-validate>
                    <legend><?php if ($action == 'addbook') { ?> Add Book <?php } else { ?>Edit Book <?php } ?> </legend>
                    <div class="tabs">
                        <div id="section-1">
                            <label>Title</label>
                            <input type="text" name="bookTitle" value="<?php if ( isset($book['bookTitle']) ) { echo $book['bookTitle']; }?>" required>
                            <label>Original Title</label>
                            <input type="text" name="originalTitle" value="<?php if ( isset($book['originalTitle']) ) { echo $book['originalTitle']; }?>" required>
                            <label>Year of Publication</label>
                            <input type="text" name="yearofPublication" value="<?php if ( isset($book['yearofPublication']) ) { echo $book['yearofPublication']; }?>" required>
                            <label>Genre</label>
                            <input type="text" name="genre" value="<?php if ( isset($book['genre']) ) { echo $book['genre']; }?>" required>
                            <label>Millions Sold</label>
                            <input type="text" name="millionsSold" value="<?php if ( isset($book['millionsSold']) ) { echo $book['millionsSold']; }?>" required>
                            <label>Language Written</label>
                            <input type="text" name="languageWritten" value="<?php if ( isset($book['languageWritten']) ) { echo $book['languageWritten']; }?>" required>
                            <div class="formNav">
                                <a id="section1Next" href="#" class="next-btn">Next</a>
                                <div class="clear"></div>
                            </div>
                        </div>
                        <div id="section-2" class="hiddenStep">
                            <?php if ($action == 'addbook') { ?>
                                <div class="selectionFieldGroup">
                                     <label>Author</label>
                                     <div class="radio">
                                         <label><input type="radio" name="authorSelect" value="existingAuthor" required>
                                         Existing Author</label>
                                     </div>
                                     <div class="radio">
                                         <label><input type="radio" name="authorSelect" value="newAuthor">
                                         New Author</label>
                                     </div>
                                 </div>

                            <?php    } ?>
                            <div id="existingAuthor">
                                <select class="" name="authorOption">
                                    <option value="" disabled selected>Select Author</option>
                                    <?php foreach ($authors as $author) { ?>
                                        <option value="<?php echo $author['authorID']; ?>"><?php echo $author['firstName']." ".$author['lastName']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div id="newAuthor">
                                <h4>Author Details</h4>
                                <label>First Name</label>
                                <input type="text" name="firstName" value="<?php if ( isset($book['firstName']) ) { echo $book['firstName']; }?>">
                                <label>Surname</label>
                                <input type="text" name="lastName" value="<?php if ( isset($book['lastName']) ) { echo $book['lastName']; }?>">
                                <label>Nationality</label>
                                <input type="text" name="nationality" value="<?php if ( isset($book['nationality']) ) { echo $book['nationality']; }?>">
                                <label>Year of Birth</label>
                                <input type="text" name="birthYear" value="<?php if ( isset($book['birthYear']) ) { echo $book['birthYear']; }?>">
                                <label>Year of Death</label>
                                <input type="text" name="deathYear" value="<?php if ( isset($book['deathYear']) ) { echo $book['deathYear']; }?>">
                            </div>
                            <div class="formNav">
                                <a href="#" id="section2Prev" class="prev-btn">Prev</a>
                                <a href="#" id="section2Next" class="next-btn">Next</a>
                            </div>
                        </div>
                        <div id="section-3" class="hiddenStep">
                            <label>Book Plot</label>
                            <textarea class="form-control" rows="5" name="plot" required><?php if ( isset($bookplot['plot']) ) { echo $bookplot['plot']; }?></textarea>
                            <label>Plot Source</label>
                            <input type="text" name="plotSource" value="<?php if ( isset($bookplot['plotSource']) ) { echo $bookplot['plotSource']; }?>" required>
                            <label>Book Ranking</label>
                            <input type="text" name="rankingScore" value="<?php if ( isset($ranking['rankingScore']) ) { echo $ranking['rankingScore']; }?>" required>
                            <label>Book Cover</label>
                            <input type="file" class="item-img <?php if ( !empty($book['coverImage']) ){ echo 'hideElement'; } ?>" id="coverImageSelect" accept="image/*"/>
                            <input type="hidden" class="deleteCoverImage" name="deleteCoverImage" value="">
                            <input type="hidden" class="coverImageOutput" name="coverImage" value="">
                            <div class=" image-output">
                                <img src="<?php if ( !empty($book['coverImage']) ){ echo 'view/images/'.$book['coverImage']; } ?>" alt="" id="item-img-output" />
                            </div>
                            <button type="button" name="button" class="deleteImage <?php if ( !empty($book['coverImage']) ){ echo 'showElement'; } ?>"> <span><img src="view/images/remove.png" alt=""></span> Remove</button>
                            <!-- Modal -->
                            <div id="cropImagePop" class="modal fade" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Crop Image</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                                        </div>
                                        <div class="modal-body">
                                            <div class="col-xs-12 col-sm-4 col-sm-offset-4">
                                                <div style="display: block; width: 300px; height: 300px;">
                                                    <div id="upload-demo"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default clearImageBtn" data-dismiss="modal">Close</button>
                                            <button type="button" id="cropImageBtn" class="btn btn-primary">Crop</button>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->
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
