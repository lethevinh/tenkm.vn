
window.admin = window.admin || {};
window.admin.init =  function () {
    console.log('Init Edureal Admin');
    admin.setCurrentTag();
}
window.admin.setCurrentTag =  function () {
    console.log(window.location.hash)
    if(window.location.hash && window.location.hash.includes('#tab-form') ) {
        $('[href^="' + window.location.hash.substring(0, 11) + '"]').trigger('click');
    }
}
window.admin.dialogAfterSave = async function () {
   await Dcat.reload();
};
$('.btn-nestable-save').click(function() {
    let selector = $(this).data('nestable-selector');
    let treeSelected = $('#'+selector);
    let data = treeSelected.nestable('serialize');
    if (data.length > 0) {
        let section = data[0];
        if (section.children.length > 0) {
            Dcat.loading();
            section.children.map(async function (lecture, index) {
                await $.post('/admin/lectures/' + lecture.id, {
                    order_nb:index,
                    '_token':Dcat.token,
                    '_method': 'PUT'
                });
                if (index === section.children.length - 1) {
                    Dcat.loading(false);
                    await window.admin.dialogAfterSave();
                }
            });
        }
    }
})
$(document).ready(function () {
    admin.setCurrentTag();
});

