document.addEventListener('DOMContentLoaded', function() {
    // HSL (色相, 彩度, 明度) を使ってパステルカラーを生成します

    let hue; // ★ const から let に変更し、初期値なしにする
    const avoidHueLower1 = 300; // 避ける範囲1の下限 (ピンク/マゼンタ系)
    const avoidHueUpper1 = 360; // 避ける範囲1の上限
    const avoidHueLower2 = 0;   // 避ける範囲2の下限 (赤系)
    const avoidHueUpper2 = 20;   // 避ける範囲2の上限

    // ★ 避けるべき色相範囲でなくなるまで、hue をランダムに生成し続ける
    do {
      hue = Math.floor(Math.random() * 361); // 0から360のランダムな色相を生成
    } while (
      (hue >= avoidHueLower1 && hue <= avoidHueUpper1) || // 範囲1 (300-360) か、
      (hue >= avoidHueLower2 && hue < avoidHueUpper2)     // 範囲2 (0-19) の場合、ループを続ける
    );

    // 2. 彩度 (パステル調にするため、少し低めの範囲でランダムに。例: 60%～90%)
    const saturation = Math.floor(Math.random() * 31) + 60; // 60から90の間のランダムな値
  
    // 3. 明度 (範囲を広げつつ、少し落ち着いた範囲に調整。例: 65%～80%)
    const lightness = Math.floor(Math.random() * 16) + 65; // 65から80の間のランダムな値
    
    // 4. アルファ値 (透明度) を設定 (0: 完全透明, 1: 完全不透明)
    const alpha = 0.5; // 例: 90% 不透明 (少しだけ透明にしたい場合)
    // この数値を 0.8 や 0.85 などに変えて調整できます

    // 生成したHSL値とアルファ値をCSSの形式 (HSLA) に組み立てる
    const randomPastelColor = `hsla(${hue}, ${saturation}%, ${lightness}%, ${alpha})`; // hsl を hsla に変更し、alpha を追加

    // body要素の背景色を生成した色に変更する
    document.body.style.backgroundColor = randomPastelColor;

    // (デバッグ用) コンソールに生成された色を表示したい場合
    // console.log('背景色:', randomPastelColor);

  });
  