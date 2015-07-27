function display(path) {
    // ランダムに画像を表示する
    img = new Array();
    // ジャンプ先のアドレス(数字は画像と対応)
    // 画像のアドレス(数字はジャンプ先のアドレスと対応)
    img[0] = path +"/img/home/osaka_00.jpg";
    img[1] = path +"/img/home/osaka_01.jpg";
    img[2] = path +"/img/home/osaka_02.jpg";
    img[3] = path +"/img/home/osaka_03.jpg";
    img[4] = path +"/img/home/osaka_04.jpg";
    img[5] = path +"/img/home/osaka_05.jpg";
    img[6] = path +"/img/home/osaka_06.jpg";
    img[7] = path +"/img/home/osaka_07.jpg";
    img[8] = path +"/img/home/osaka_08.jpg";
    img[9] = path +"/img/home/osaka_09.jpg";

    n = Math.floor(Math.random()*img.length);
    document.write("<a href='"+img[n]+"' rel='lightbox'>");
    document.write("<img src='"+img[n]+"' border='0' style='height:300px;'>");
    document.write("</a>");
}