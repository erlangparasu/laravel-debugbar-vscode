<!--
    phpdebugbar plugin openeditor
    Created by: Erlang Parasu 2019
-->
<style>
    .phpdebugbar-plugin-openeditorbutton {
        font-size: 12px !important;
        display: inline-block !important;
        color: #000 !important;
        border: 1px solid #9d9090 !important;
        border-radius: 3px !important;
        box-shadow: 0px 2px 3px #00000069 !important;
        padding-left: 8px !important;
        padding-right: 8px !important;
        padding-top: 4px !important;
        padding-bottom: 4px !important;
        margin-left: 8px !important;
        margin-right: 4px !important;
        margin-bottom: 0px !important;
        cursor: pointer !important;
    }

    .phpdebugbar-widgets-list-item {
        align-items: baseline !important;
    }
</style>
<script>
    var _phpDebugBarPluginVscodeIsLoaded = false;

    var _funPhpDebugBarPluginVscodeInit = function () {
        if ($) {
            //
        } else {
            return;
        }

        if ($('.phpdebugbar').length) {
            //
        } else {
            return;
        }

        if (_phpDebugBarPluginVscodeIsLoaded) {
            return;
        }

        $(function onDocumentReady() {
            function getEditorName() {
                return "{{ (isset($phpdebugbar_editor) ? $phpdebugbar_editor : 'vscode') }}";
            }

            function getBasePath() {
                return "{{ str_replace('\\', '/', base_path()) }}";
            }

            function isPhp(str) {
                return str.indexOf('.php') != -1;
            }

            function isController(str) {
                return str.indexOf('.php:') != -1;
            }

            function isBlade(str) {
                return str.indexOf('.blade.php') != -1;
            }

            function getLink(str) {
                var result = '';

                // TODO: Link to other editor
                result += getEditorName();
                result += '://file/';
                result += getBasePath();

                if (isBlade(str)) {
                    var iRes = str.indexOf('resources');
                    if (iRes != -1) {
                        str = str.substring(iRes - 1);
                        var iViews = str.indexOf('views');
                        if (iViews != -1) {
                            var iEnd = str.indexOf(')', iViews);
                            if (iEnd != -1) {
                                str = str.substring(0, iEnd);
                                result += str;
                            }
                        }
                    }
                } else if (isController(str)) {
                    var iRes = str.indexOf('.php:');
                    if (iRes != -1) {
                        var iLastDash = str.lastIndexOf('-');
                        result += str.substring(0, iLastDash);
                    }
                }

                return result;
            }

            var funOnHoverIn = function (e) {
                e.stopPropagation();

                var str = $(this).html();
                if (isPhp(str) || isBlade(str) || isController(str)) {
                    // OK
                } else {
                    return;
                }

                if (str.indexOf('vscode_debugbar_plugin') == -1) {
                    // OK
                } else {
                    return;
                }

                if (isBlade(str)) {
                    var oldHtml = $(this).parent().html();
                    var strNewLink = '';
                    if (oldHtml.indexOf('phpdebugbar-plugin-openeditorbutton') == -1) {
                        strNewLink = '<a class="phpdebugbar-plugin-openeditorbutton" onclick="phpdebugbar_plugin_openEditorClicked(event, this);" data-link="' + getLink(str) + '">' +  '&#9998;' +  '</a>';
                    }
                    $(strNewLink).insertAfter($(this));
                } else if (isController(str)) {
                    var oldHtml = $(this).html();
                    var strNewLink = '';
                    if (oldHtml.indexOf('phpdebugbar-plugin-openeditorbutton') == -1) {
                        strNewLink = '<a class="phpdebugbar-plugin-openeditorbutton" onclick="phpdebugbar_plugin_openEditorClicked(event, this);" data-link="' + getLink(str) + '">' +  '&#9998;' +  '</a>';
                    }
                    $(strNewLink).appendTo($(this));
                }
            };

            var funOnHoverOut = function (e) {
                e.stopPropagation();
            };

            setTimeout(function () {
                $('.phpdebugbar span.phpdebugbar-widgets-name').hover(funOnHoverIn, funOnHoverOut);
                $('.phpdebugbar dd.phpdebugbar-widgets-value').hover(funOnHoverIn, funOnHoverOut);
            }, 5);
        });

        _phpDebugBarPluginVscodeIsLoaded = true;
        clearInterval(_phpDebugBarPluginVscodeInterval);
    }

    var _phpDebugBarPluginVscodeInterval = setInterval(_funPhpDebugBarPluginVscodeInit, 3000);

    function phpdebugbar_plugin_openEditorClicked(ev, el) {
        window.location.href = $(el).data('link');
        event.stopPropagation();
    }
</script>