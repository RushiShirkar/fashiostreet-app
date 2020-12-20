
import axios from 'axios';
const instance=axios.create({
  baseURL:'https://fashiostreet.com',
  headers:{
    'token':localStorage.getItem('token'),
    'local-id':localStorage.getItem('local_id')
  }
});
export default instance

/*
import axios from 'axios';
const instance=axios.create({
  baseURL:'http://localhost/www.fashiostreet.com/fashiostreet_client/public',
  headers:{
    'token':localStorage.getItem('token'),
    'local-id':localStorage.getItem('local_id')
  }
});
export default instance
*/