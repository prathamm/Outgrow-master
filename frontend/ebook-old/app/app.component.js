"use strict";
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var core_1 = require('@angular/core');
var router_deprecated_1 = require('@angular/router-deprecated');
var header_component_1 = require('./header/header.component');
var sidebar_component_1 = require('./sidebar/sidebar.component');
var mock_chapters_1 = require('./chapter/mock-chapters');
var chapter_component_1 = require('./chapter/chapter-1/chapter.component');
var chapter_component_2 = require('./chapter/chapter-2/chapter.component');
var chapter_component_3 = require('./chapter/chapter-3/chapter.component');
var chapter_component_4 = require('./chapter/chapter-4/chapter.component');
var chapter_component_5 = require('./chapter/chapter-5/chapter.component');
var chapter_component_6 = require('./chapter/chapter-6/chapter.component');
var chapter_component_7 = require('./chapter/chapter-7/chapter.component');
var AppComponent = (function () {
    function AppComponent() {
        this.thisChapter = {
            currentChapter: mock_chapters_1.CHAPTERS[0],
            prevChapter: mock_chapters_1.CHAPTERS[0],
            nextChapter: mock_chapters_1.CHAPTERS[1]
        };
    }
    AppComponent = __decorate([
        core_1.Component({
            selector: 'my-app',
            template: "\n\t  \t<header [currentChapter]=\"thisChapter\"></header>\n\t\t<sidebar [currentChapter]=\"thisChapter\"></sidebar>\n\t\t<router-outlet></router-outlet>\n\t",
            directives: [header_component_1.HeaderComponent, sidebar_component_1.SidebarComponent, router_deprecated_1.ROUTER_DIRECTIVES],
            providers: [router_deprecated_1.ROUTER_PROVIDERS]
        }),
        router_deprecated_1.RouteConfig([
            {
                path: '/',
                name: 'Home',
                component: chapter_component_1.ChapterOneComponent,
                useAsDefault: true
            },
            {
                path: '/chapter/' + mock_chapters_1.CHAPTERS[0].path,
                name: 'Chapter-1',
                component: chapter_component_1.ChapterOneComponent
            },
            {
                path: '/chapter/' + mock_chapters_1.CHAPTERS[1].path,
                name: 'Chapter-2',
                component: chapter_component_2.ChapterTwoComponent
            },
            {
                path: '/chapter/' + mock_chapters_1.CHAPTERS[2].path,
                name: 'Chapter-3',
                component: chapter_component_3.ChapterThreeComponent
            },
            {
                path: '/chapter/' + mock_chapters_1.CHAPTERS[3].path,
                name: 'Chapter-4',
                component: chapter_component_4.ChapterFourComponent
            },
            {
                path: '/chapter/' + mock_chapters_1.CHAPTERS[4].path,
                name: 'Chapter-5',
                component: chapter_component_5.ChapterFiveComponent
            },
            {
                path: '/chapter/' + mock_chapters_1.CHAPTERS[5].path,
                name: 'Chapter-6',
                component: chapter_component_6.ChapterSixComponent
            },
            {
                path: '/chapter/' + mock_chapters_1.CHAPTERS[6].path,
                name: 'Chapter-7',
                component: chapter_component_7.ChapterSevenComponent
            }
        ])
    ], AppComponent);
    return AppComponent;
}());
exports.AppComponent = AppComponent;
//# sourceMappingURL=app.component.js.map