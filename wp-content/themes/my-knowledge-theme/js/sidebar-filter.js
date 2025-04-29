jQuery(document).ready(function() { // ← 引数 $ を削除

    // 「もっと見る/閉じる」ボタンの処理
    jQuery('.toggle-visibility-button').each(function() { // ← jQuery に変更
        var $button = jQuery(this); // ← jQuery に変更 (変数名はそのままでOK)
        var targetListSelector = $button.data('target-list');
        var $targetList = jQuery(targetListSelector); // ← jQuery に変更 (変数名はそのままでOK)
        var initialMaxHeight = 150;

        if ($targetList.length === 0) {
            $button.hide();
            return;
        }

        var originalMaxHeight = $targetList.css('max-height');
        $targetList.css('max-height', 'none');
        var actualHeight = $targetList.outerHeight();
        $targetList.css('max-height', originalMaxHeight);

        if (actualHeight <= initialMaxHeight) {
             $button.hide();
        } else {
             $button.show();
        }

        $button.on('click', function(e) {
            e.preventDefault();

            if ($targetList.hasClass('show-all')) {
                $targetList.removeClass('show-all');
                $button.text('もっと見る');
            } else {
                $targetList.addClass('show-all');
                $button.text('閉じる');
            }
        });
    });

    // リアルタイムフィルター検索の処理
    jQuery('.filter-search-input').each(function() { // ← jQuery に変更
        var $input = jQuery(this); // ← jQuery に変更 (変数名はそのままでOK)
        var targetListSelector = $input.data('filter-target');
        var $targetList = jQuery(targetListSelector); // ← jQuery に変更 (エラー箇所付近, 変数名OK)
        var $listItems = $targetList.find('li'); // ← jQuery に変更 (変数名OK)
        var $toggleButton = $input.closest('.widget').find('.toggle-visibility-button'); // ← jQuery に変更 (変数名OK)

        if ($targetList.length === 0 || $listItems.length === 0) {
            $input.parent('.filter-search-wrapper').hide();
            return;
        }

        $input.on('input keyup', function() { // ← jQuery に変更
            var searchTerm = $input.val().toLowerCase().trim();

            var wasShowAll = $targetList.hasClass('show-all');
            $targetList.addClass('show-all');
            $toggleButton.hide();

            if (searchTerm === '') {
                $listItems.show();
                if (!wasShowAll) {
                    $targetList.removeClass('show-all');
                }
                // checkToggleButtonVisibility 関数は $ を使っていないので修正不要
                checkToggleButtonVisibility($toggleButton, $targetList);

            } else {
                var matchCount = 0;
                $listItems.each(function() {
                    var $item = jQuery(this); // ← jQuery に変更 (変数名OK)
                    var itemText = $item.text().toLowerCase();

                    if (itemText.includes(searchTerm)) {
                        $item.show();
                        matchCount++;
                    } else {
                        $item.hide();
                    }
                });
            }
        });
    });

    // 「もっと見る」ボタンの表示/非表示をチェックする補助関数
    // この関数内では $ を使っていないので修正不要
    function checkToggleButtonVisibility($button, $targetList) {
        var initialMaxHeight = 150;
        if ($targetList.length === 0) return;

        var originalMaxHeight = $targetList.css('max-height');
        $targetList.css('max-height', 'none');
        var actualHeight = $targetList.outerHeight();
        $targetList.css('max-height', originalMaxHeight);

        if (actualHeight <= initialMaxHeight) {
             $button.hide();
        } else {
             $button.show();
        }
    }

}); // ← 閉じ括弧
