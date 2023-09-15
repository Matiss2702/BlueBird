<div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content">
        <?php $this->partial('back/topbar'); ?>
        <div class="container-fluid">
            <div class="bg-white">
                <div class="d-flex justify-content-between align-items-center p-3">
                    <h4 class="h4 font-weight-bold text-primary">Message</h4>
                    <a href="/admin/message/create" class="btn btn-primary btn-sm">
                        <i class="fa fa-plus"></i>
                        <span>Créer un nouveau message</span>
                    </a>
                </div>
                <?php if ($messages) : ?>
                    <table class="table display dataTable mt-4 " id="message-list">
                        <thead class="thead-light">
                            <tr>
                                <th class="d-table-cell">ID</th>
                                <th>Object</th>
                                <th>Firstname</th>
                                <th>Message</th>
                                <th>Date de création</th>
                                <th class="d-table-cell">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($messages as $message) : ?>
                                <tr>
                                    <td class="d-table-cell"><?= $message->id ?></td>
                                    <td><?= $message->object ?></td>
                                    <td>
                                        <?= $message->firstname ?>
                                        <span class="truncated-message-og" hidden><?= $message->message ?></span>
                                    </td>
                                    <td class="truncated-message"><?= $message->message ?></td>
                                    <td><?= date('Y-m-d H:i:s', strtotime($message->created_at)) ?></td>
                                    <td class="d-table-cell">
                                        <a href="/admin/message/show/<?= $message->id ?>" class="btn btn-secondary btn-sm"><i class="fa fa-eye"></i></a>
                                        <a href="/admin/message/edit/<?= $message->id ?>" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                        <a href="/admin/message/delete/<?= $message->id ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot class="thead-light">
                            <tr>
                                <th class="d-table-cell">ID</th>
                                <th>Object</th>
                                <th>Firstname</th>
                                <th>Message</th>
                                <th>Date de création</th>
                                <th class="d-table-cell">Action</th>
                            </tr>
                        </tfoot>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        function truncateMessage(element, ogMessage, maxLength) {
            if (element.textContent.length > maxLength) {
                element.textContent = element.textContent.substring(0, maxLength) + '...';
            } else {
                element.textContent = ogMessage.textContent.substring(0, maxLength) + '...';
            }
        }

        function handleResize(truncatedMessages, ogMessages) {
            const maxWidth = window.innerWidth <= 1180 ? 30 : 48;

            truncatedMessages.forEach((truncatedMessage, key) => {
                truncateMessage(truncatedMessage, ogMessages[key], maxWidth);
            });
        }

        window.addEventListener('DOMContentLoaded', () => {
            const truncatedMessages = document.querySelectorAll('.truncated-message');
            const ogMessages = document.querySelectorAll('.truncated-message-og');
            handleResize(truncatedMessages, ogMessages);
        });

        window.addEventListener('resize', () => {
            const truncatedMessages = document.querySelectorAll('.truncated-message');
            const ogMessages = document.querySelectorAll('.truncated-message-og');
            handleResize(truncatedMessages, ogMessages);
        });
    </script>