export default {
  length:function(str){
    var length = str.length;
    if(length==10)
      return true;
    return false;
  },
  lengthpass:function(str){
    var length = str.length;
    if(length>=6)
      return true;
    return false;
  },
  isEmpty:function(str){
    if(str == null || str == '')
      return true;
    return false;
  },
  isNumeric:function(str,min,max) {
    var pattern = /^\d+$/;
    if(this.length(str,min,max))
    {
      return pattern.test(str);  // returns a boolean
    }
    return false;
  },
  isUserLogin:function(){
    var local_id = localStorage.getItem('local_id');
    var token = localStorage.getItem('token');
    if(local_id != null && token != null)
    {
      return true;
    }
    return false;
  }
}
