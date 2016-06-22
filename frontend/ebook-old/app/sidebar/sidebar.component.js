"use strict";
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var core_1 = require('@angular/core');
var router_deprecated_1 = require('@angular/router-deprecated');
var mock_chapters_1 = require('./../chapter/mock-chapters');
var SidebarComponent = (function () {
    function SidebarComponent() {
        this.chapters = mock_chapters_1.CHAPTERS;
    }
    SidebarComponent.prototype.onSelect = function (chapter) {
        this.currentChapter = {
            currentChapter: mock_chapters_1.CHAPTERS[chapter.id - 1],
            prevChapter: mock_chapters_1.CHAPTERS[chapter.id - 2],
            nextChapter: mock_chapters_1.CHAPTERS[chapter.id]
        };
    };
    __decorate([
        core_1.Input()
    ], SidebarComponent.prototype, "currentChapter");
    SidebarComponent = __decorate([
        core_1.Component({
            selector: 'sidebar',
            templateUrl: 'app/sidebar/sidebar.component.html',
            directives: [router_deprecated_1.RouterLink]
        })
    ], SidebarComponent);
    return SidebarComponent;
}());
exports.SidebarComponent = SidebarComponent;
//# sourceMappingURL=sidebar.component.js.map