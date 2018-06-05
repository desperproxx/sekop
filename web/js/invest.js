/**
 * Created by denis.ponimarev on 05.08.2016.
 */
function setLocation(curLoc){
    try {
        history.pushState(null, null, curLoc);
        return;
    } catch(e) {}
}