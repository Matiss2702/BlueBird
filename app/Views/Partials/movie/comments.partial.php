<section class="mb-5">
    <div class="card bg-light">
        <div class="card-body">
            <?php if (!$isConnected): ?> 
                <div class="text-center py-2 mb-3">
                    Vous souhaitez partager votre avis ? <a href="/login">Connectez-vous</a>
                </div>
            <?php endif; ?>
            <h5 class="font-weight-bold mb-4">Commentaires</h5>
            <?php if ($isConnected): ?> 
                <form id="comment-form" class="mb-4">
                    <textarea name="comment" class="form-control" placeholder="Rejoignez la discussion et partagez votre avis..."></textarea>
                    <?php if(isset($errors['comment'])): ?>
                        <?php foreach($errors['comment'] as $error): ?>
                            <div class="text-danger"><?= $error; ?></div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <button type="submit" class="btn btn-primary btn-sm mt-1">Envoyer</button>
                </form>
            <?php endif; ?>

            <div class="mb-4">
                <?php if ($comments): ?>
                    <?php foreach($comments as $comment): ?>
                        <div class="media mb-3">
                            <?php $profileImage = '/img/undraw_profile_' . mt_rand(1, 3) . '.svg'; ?>
                            <img class="rounded-circle mr-2" src="<?= $profileImage ?>" width="32" alt="Profile Picture">
                            <div class="media-body">
                                <h6 class="font-weight-bold"><?= $comment->getUserName() ?></h6>
                                <p><?= $comment->getContent() ?></p>
                                <?php if ($isConnected): ?>
                                    <div class="btn btn-sm reply-button" data-comment-id="<?= $comment->getId() ?>">
                                        <i class="fas fa-reply mr-2"></i><span>Répondre</span>
                                    </div>
                                <?php endif; ?>
                                <?php if ($comment->getReplies()): ?>
                                    <?php foreach($comment->getReplies() as $reply): ?>
                                        <div class="media mt-3">
                                            <?php $replyProfileImage = '/img/undraw_profile_' . mt_rand(1, 3) . '.svg'; ?>
                                            <img class="rounded-circle mr-2" src="<?= $replyProfileImage ?>" width="32" alt="Profile Picture">
                                            <div class="media-body">
                                                <h6 class="font-weight-bold"><?= $reply->getUserName() ?></h6>
                                                <p><?= $reply->getContent() ?></p>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                <?php if ($isConnected): ?>
                                    <form class="mt-3 reply-form d-none">
                                        <textarea class="form-control" placeholder="Répondre au commentaire..."></textarea>
                                        <button type="submit" class="btn btn-primary btn-sm mt-2">Envoyer</button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="w-100 text-center text-white">Aucun commentaire pour l'instant, soyez le premier !</div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</section>

<script>
    $(document).ready(function() {
        $('#comment-form').submit(function(e) {
            e.preventDefault();

            var commentContent = $(this).find('textarea').val();
            var movieId = <?= $movie->getId() ?>;
            var userId = <?= $idUser ?>;

            var form = this;

            $.ajax({
            url: '/comment/store',
            type: 'POST',
            data: {
                entity: 'movie',
                id_entity: movieId,
                id_user: userId,
                content: commentContent
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    var successMessage = $('<div>').addClass('alert alert-success mt-2').text('Le commentaire a été envoyé avec succès. Il sera vérifié avant d\'être rendu public.');
                    $(form).after(successMessage);
                    $(form).find('textarea').val('');

                    // Cacher le message de succès après 4 secondes
                    setTimeout(function() {
                        successMessage.fadeOut('slow', function() {
                        successMessage.remove();
                        });
                    }, 4000);
                } else {
                    if (response.errors) {
                        for (var error in response.errors) {
                        var errorMessage = $('<div>').addClass('alert alert-danger mt-2').text(response.errors[error]);
                        $(form).after(errorMessage);
                        }
                        $(form).find('textarea').val('');

                        // Cacher le message d'erreur après 4 secondes
                        setTimeout(function() {
                        errorMessage.fadeOut('slow', function() {
                            errorMessage.remove();
                        });
                        }, 4000);
                    }
                }
            },
            error: function() {
                console.error('Erreur AJAX');
            }
            });
        });

        $('.reply-button').click(function() {
            $(this).closest('.media').find('.reply-form').toggleClass('d-none');
        });

        $('.reply-form').submit(function(e) {
            e.preventDefault();

            var commentId = $(this).closest('.media').find('.reply-button').attr('data-comment-id');
            var replyContent = $(this).find('textarea').val();
            var userId = '<?= $idUser ?>';

            var form = this;

            $.ajax({
                url: '/comment/reply/store',
                type: 'POST',
                data: {
                    content: replyContent,
                    id_user: userId,
                    id_comment: commentId
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        var successMessage = $('<div>').addClass('alert alert-success mt-2').text('Le commentaire a été envoyé avec succès. Il sera vérifié avant d\'être rendu public.');
                        $(form).closest('.media').find('.reply-form').addClass('d-none');
                        $(form).after(successMessage);
                        $(form).find('textarea').val('');

                        // Cacher le message de succès après 4 secondes
                        setTimeout(function() {
                            successMessage.fadeOut('slow', function() {
                                successMessage.remove();
                            });
                        }, 4000);
                    } else {
                        if (response.errors) {
                            for (var error in response.errors) {
                                var errorMessage = $('<div>').addClass('alert alert-danger mt-2').text(response.errors[error]);
                                $(form).after(errorMessage);
                            }
                            $(form).find('textarea').val('');

                            // Cacher le message de succès après 4 secondes
                            setTimeout(function() {
                                errorMessage.fadeOut('slow', function() {
                                    errorMessage.remove();
                                });
                            }, 4000);
                        }
                    }
                },
                error: function() {
                    console.error('Erreur AJAX');
                }
            });
        });
    });
</script>