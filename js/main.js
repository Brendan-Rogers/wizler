

new Vue({

    el: '#app',
    name: 'app',
    data() {
        return {
            options: {
                controlArrows: true,
                // scrollBar: true,
                menu: '#navList',
                navigation: true,
                anchors: ['page1', 'page2', 'page3', 'page4', 'page5'],


            }
        }
    },
    methods: {
        afterLoad: function () {
        },
        toggleNavigation: function () {
            this.options.navigation = !this.options.navigation
        },
        toggleScrollbar: function () {
            this.options.scrollBar = !this.options.scrollBar
        }
    }
})






