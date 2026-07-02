;(function (window) {
    'use strict';

    if (window.JCOrigamiHeaderOneTopMenu) {
        return;
    }
    
    window.JCOrigamiHeaderOneTopMenu = function () {
        this.sizeChange = [];
        this.navigation = document.querySelectorAll('.visible-links .visible-links__item');
        this.nodes = {
            navContainer: document.querySelector('.oh1-top-menu__list'),
            topElements: Array.prototype.slice.call(document.querySelectorAll('.oh1-top-menu__list-item:not(.mm-listitem)')),
            arNavItems: Array.prototype.slice.call(document.querySelectorAll('.oh1-top-menu > .oh1-top-menu__list-item')),
            showMore: document.querySelector('.oh1-top-menu__list-item[data-more]'),
            showMoreContainer: document.querySelector('.oh1-top-menu__list-item[data-more] .oh1-top-menu__sublist')
        }
        this.arTopElementsWidth = [];
        BX.ready(function () {
            this.init()
        }.bind(this))
    }

    window.JCOrigamiHeaderOneTopMenu.prototype = {
        init: function() {
            this.memoElementsWidth();
            setTimeout(() => {this.moveLinksToHidden()}, 200);
            window.addEventListener('resize', () => {
                if (this.nodes.navContainer.clientWidth > 0 ) {
                    this.moveLinksToHidden()
                }
            });
            window.addEventListener('scroll', () => {
                if (this.nodes.navContainer.clientWidth > 0 ) {
                    this.moveLinksToHidden()
                }
            });
        },
        memoElementsWidth: function () {
            let sumWidth = 0;
            this.arTopElementsWidth = this.nodes.topElements.map((element, index) => {
                let elementWidth = element.getBoundingClientRect().width;
                sumWidth = sumWidth + elementWidth;
                return {
                    width: elementWidth,
                    sumWidth: sumWidth,
                    index: index,
                }
            })
        },
        getVisibleLinksCount: function() {
            return this.arTopElementsWidth.reduce((acc, el, i, arr)=>{
                return el.sumWidth < document.querySelector('.oh1-top-menu').clientWidth ? i : acc;
            }, 0)
        },
        moveLinksToHidden: function() {
            let count = this.getVisibleLinksCount();
            this.nodes.topElements.forEach((e,i) => {
                if (i >= count ) {
                    try {
                        this.nodes.showMoreContainer.appendChild(e)
                    } catch {}
                    
                } else {
                    try {
                        this.nodes.navContainer.appendChild(e)
                    } catch {}
                }
            })
            this.nodes.navContainer.appendChild(this.nodes.showMore)
            if (this.nodes.showMoreContainer.childElementCount === 0) {
                this.nodes.showMore.dataset.more = false
            } else {
                this.nodes.showMore.dataset.more = true
            }
        }
    }
})(window);
