import axios from 'axios'
const instance = axios.create({
  baseURL : 'https://seller.fashiostreet.com/api'
});
export default instance