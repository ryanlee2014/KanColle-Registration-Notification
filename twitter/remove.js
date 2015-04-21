var imgs = document.getElementsByTagName("img");
for(i=0; i<imgs.length; i++)
{
    imgs[i].parentNode.removeChild(imgs[i]);
}