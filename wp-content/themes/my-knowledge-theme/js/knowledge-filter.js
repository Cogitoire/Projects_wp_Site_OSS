jQuery(document).ready(function($) {

    // --- 折りたたみ機能 ---
    $('.filter-collapsible .filter-legend-toggle').on('click', function() {
        var $fieldset = $(this).closest('.filter-collapsible');
        var $options = $fieldset.find('.filter-options');

        // 開閉状態をトグル
        $options.slideToggle(200); // 200ミリ秒でアニメーション

        // legend にクラスを追加/削除して状態を示す (CSSで矢印などを表示するため)
        $fieldset.toggleClass('is-open');
    });

    // --- リアルタイム検索機能 ---
    $('.filter-collapsible .filter-search-input').on('input', function() {
        var $input = $(this);
        var $fieldset = $input.closest('.filter-collapsible');
        var $optionsContainer = $fieldset.find('.filter-options');
        var searchTerm = $input.val().toLowerCase().trim(); // 入力値を小文字にして前後の空白を削除

        // 検索語が空なら全てのラベルを表示して終了
        if (searchTerm === '') {
            $optionsContainer.find('label').show();
            return;
        }

        // 各ラベルをチェック
        $optionsContainer.find('label').each(function() {
            var $label = $(this);
            var labelText = $label.text().toLowerCase(); // ラベルテキストを小文字に

            // ラベルテキストに検索語が含まれているかチェック
            if (labelText.includes(searchTerm)) {
                $label.show(); // 含まれていれば表示
            } else {
                $label.hide(); // 含まれていなければ非表示
            }
        });
    });

    // 初期状態で選択されている項目がある場合は開いておく (任意)
    $('.filter-collapsible:has(input:checked)').addClass('is-open').find('.filter-options').show();

});