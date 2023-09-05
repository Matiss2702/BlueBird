$(document).ready(function () {
    const versionsSelect = $("#versions");
    const titleInput = $("#title");
    const slugInput = $("#slug");
    const descriptionInput = $("#description");

    versionsSelect.on("change", function () {
        const selectedOption = versionsSelect.find("option:selected");
        const versionData = selectedOption.data("version-data");

        titleInput.val(versionData.title);
        slugInput.val(versionData.slug);
        descriptionInput.val(versionData.description);
        tinymce.get('content').setContent(versionData.content);
    });
});