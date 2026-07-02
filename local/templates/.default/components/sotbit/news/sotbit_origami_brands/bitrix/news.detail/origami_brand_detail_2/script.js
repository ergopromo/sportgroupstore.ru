window.addEventListener('resize', activeCollapse);

window.addEventListener('DOMContentLoaded', () => {
    setCollapseButtonsEvents();
    activeCollapse();
});

function activeCollapse() {
    const block = document.querySelector('.brand-detail-info__description');
    if(!block) {
        return
    }

    const textWrapper = block.querySelector('.brand-detail-info__description-text-wrapper');
    const collapseButtonsWrapper = document.querySelector('.brand-detail-info__collapse-btns');
    const text = document.querySelector('.brand-detail-info__description-text');
    const height = (window.innerWidth <= 768)
        ? 200
        : 210;

    if (text.offsetHeight > height) {
        collapseButtonsWrapper.style.display = 'block';
        textWrapper.style.height = height + 'px';
    } else {
        collapseButtonsWrapper.style.display = 'none';
    }
}

function showText() {
    const textWrapper = document.querySelector('.brand-detail-info__description-text-wrapper');
    const text = document.querySelector('.brand-detail-info__description-text');

    textWrapper.style.height = text.offsetHeight + 'px';
}

function hideText() {
    const textWrapper = document.querySelector('.brand-detail-info__description-text-wrapper');
    const height = (window.innerWidth <= 768)
        ? 200
        : 210;

    textWrapper.style.height = height + 'px';
}

function setCollapseButtonsEvents() {
    const collapseButtonsWrapper = document.querySelector('.brand-detail-info__collapse-btns');
    const show = collapseButtonsWrapper.querySelector('.brand-detail-info__collapse-btns-show');
    const hide = collapseButtonsWrapper.querySelector('.brand-detail-info__collapse-btns-hide');

    show.addEventListener('click', function () {
        collapseButtonsWrapper.dataset.active = 'true';
        showText();
    });

    hide.addEventListener('click', function () {
        delete collapseButtonsWrapper.dataset.active;
        hideText();
    })
}
