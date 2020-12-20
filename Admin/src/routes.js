import validation from './packages/validation'
export default [
  {
    path: '/wallet',
    async(routeTo, routeFrom, resolve, reject) {
      // dynamic import component; returns promise
      const vueComponent = () => import('./pages/Admin/wallet.vue');
      // resolve promise
      vueComponent().then((vc) => {
        // resolve with component
        resolve({ component: vc.default })
      });
    }
  },
  {
    path: '/call',
    async(routeTo, routeFrom, resolve, reject) {
      // dynamic import component; returns promise
      const vueComponent = () => import('./pages/Admin/call.vue');
      // resolve promise
      vueComponent().then((vc) => {
        // resolve with component
        resolve({ component: vc.default })
      });
    }
  },
  {
    path: '/visitshop',
    async(routeTo, routeFrom, resolve, reject) {
      // dynamic import component; returns promise
      const vueComponent = () => import('./pages/Admin/visitshop.vue');
      // resolve promise
      vueComponent().then((vc) => {
        // resolve with component
        resolve({ component: vc.default })
      });
    }
  },
  {
    path: '/cart',
    async(routeTo, routeFrom, resolve, reject) {
      // dynamic import component; returns promise
      const vueComponent = () => import('./pages/Admin/cart.vue');
      // resolve promise
      vueComponent().then((vc) => {
        // resolve with component
        resolve({ component: vc.default })
      });
    }
  },
  {
    path: '/startpage/',
    async(routeTo, routeFrom, resolve, reject) {
      const vueComponent = () => import('./pages/StartPage.vue');
      // resolve promise
      vueComponent().then((vc) => {
        // resolve with component
        resolve({ component: vc.default })
      });
    }
  },
  {
    path: '/',
    async(routeTo, routeFrom, resolve, reject) {
      const vueComponent = () => import('./pages/Home.vue');
      // resolve promise
      vueComponent().then((vc) => {
        // resolve with component
        resolve({ component: vc.default })
      });
    }
  },
  {
    path: '/location/',
    component: Location
  },
  {
    path: '/shop/',
    async(routeTo, routeFrom, resolve, reject) {
      // dynamic import component; returns promise
      const vueComponent = () => import('./pages/Shop.vue');
      // resolve promise
      vueComponent().then((vc) => {
        // resolve with component
        resolve({ component: vc.default })
      });
    }
  },
  {
    path: '/products/',
    async(routeTo, routeFrom, resolve, reject) {
      // dynamic import component; returns promise
      const vueComponent = () => import('./pages/Products.vue');
      // resolve promise
      vueComponent().then((vc) => {
        // resolve with component
        resolve({ component: vc.default })
      });
    }
  },
  {
    path: '/order',
      async(routeTo, routeFrom, resolve, reject) {
          // dynamic import component; returns promise
          const vueComponent = () => import('./pages/Orders/order.vue');
          // resolve promise
          vueComponent().then((vc) => {
            // resolve with component
            resolve({ component: vc.default })
          });
      }
  },
  {
    path: '/productdetails/:product_id/:product_name',
    async(routeTo, routeFrom, resolve, reject) {
      // dynamic import component; returns promise
      const vueComponent = () => import('./pages/Productdetails.vue');
      // resolve promise
      vueComponent().then((vc) => {
        // resolve with component
        resolve({ component: vc.default })
      });
    }
  },
  {
    path: '/productdetails/:product_id/:product_name/photos/',
    async(routeTo, routeFrom, resolve, reject) {
      // dynamic import component; returns promise
      const vueComponent = () => import('./pages/PhotoBrowser.vue');
      // resolve promise
      vueComponent().then((vc) => {
        // resolve with component
        resolve({component: vc.default })
      });
    }
  },
  {
    path: '/search/:title/:placeholder/:flag',
    async(routeTo, routeFrom, resolve, reject) {
      // dynamic import component; returns promise
      const vueComponent = () => import('./pages/Search.vue');
      // resolve promise
      vueComponent().then((vc) => {
        // resolve with component
        resolve({ component: vc.default })
      });
    }
  },
  {
    path: '/categorymen/',
    async(routeTo, routeFrom, resolve, reject) {
      // dynamic import component; returns promise
      const vueComponent = () => import('./pages/Categorymen.vue');
      // resolve promise
      vueComponent().then((vc) => {
        // resolve with component
        resolve({ component: vc.default })
      });
    }
  },
  {
    path: '/categorywomen/',
    async(routeTo, routeFrom, resolve, reject) {
      // dynamic import component; returns promise
      const vueComponent = () => import('./pages/Categorywomen.vue');
      // resolve promise
      vueComponent().then((vc) => {
        // resolve with component
        resolve({ component: vc.default })
      });
    }
  },
  {
    path: '/categorykids/',
    async(routeTo, routeFrom, resolve, reject) {
      // dynamic import component; returns promise
      const vueComponent = () => import('./pages/Categorykids.vue');
      // resolve promise
      vueComponent().then((vc) => {
        // resolve with component
        resolve({ component: vc.default })
      });
    }
  },
  {
    path: '/categorywatch/',
    async(routeTo, routeFrom, resolve, reject) {
      // dynamic import component; returns promise
      const vueComponent = () => import('./pages/Categorywatch.vue');
      // resolve promise
      vueComponent().then((vc) => {
        // resolve with component
        resolve({ component: vc.default })
      });
    }
  },
  {
    path: '/categoryfoot/',
    async(routeTo, routeFrom, resolve, reject) {
      // dynamic import component; returns promise
      const vueComponent = () => import('./pages/Categoryfoot.vue');
      // resolve promise
      vueComponent().then((vc) => {
        // resolve with component
        resolve({ component: vc.default })
      });
    }
  },
  {
    path: '/wishlist',
    async(routeTo, routeFrom, resolve, reject) {
        const vueComponent = () => import('./pages/Admin/wishlist.vue');
        // resolve promise
        vueComponent().then((vc) => {
          // resolve with component
          resolve({ component: vc.default })
        });
      }
  },
  {
    path: '/hdorders/',
    async(routeTo, routeFrom, resolve, reject) {
      if (validation.isUserLogin()) {
        const vueComponent = () => import('./pages/Hdorders.vue');
        // resolve promise
        vueComponent().then((vc) => {
          // resolve with component
          resolve({ component: vc.default })
        });
      }
      else
      {
        const vueComponent = () => import('./pages/Login.vue');
        // resolve promise
        vueComponent().then((vc) => {
          // resolve with component
          resolve({ component: vc.default })
        });
      }
    }
  },
  {
    path: '/hdcart/',
    async(routeTo, routeFrom, resolve, reject) {
        const vueComponent = () => import('./pages/Hdcart.vue');
        // resolve promise
        vueComponent().then((vc) => {
          // resolve with component
          resolve({ component: vc.default })
        });
    }
  },
  {
    path: '/login/',
    async(routeTo, routeFrom, resolve, reject) {
      if (validation.isUserLogin()) {
        const vueComponent = () => import('./pages/Home.vue');
        // resolve promise
        vueComponent().then((vc) => {
          // resolve with component
          resolve({ component: vc.default })
        });
      }
      else
      {
        const vueComponent = () => import('./pages/Login.vue');
        // resolve promise
        vueComponent().then((vc) => {
          // resolve with component
          resolve({ component: vc.default })
        });
      }
    }
  },
  {
    path: '/signup/',
    async(routeTo, routeFrom, resolve, reject) {
      if (validation.isUserLogin()) {
        const vueComponent = () => import('./pages/Home.vue');
        // resolve promise
        vueComponent().then((vc) => {
          // resolve with component
          resolve({ component: vc.default })
        });
      }
      else
      {
        const vueComponent = () => import('./pages/Signup.vue');
        // resolve promise
        vueComponent().then((vc) => {
          // resolve with component
          resolve({ component: vc.default })
        });
      }
    }
  },
  {
    path: '/activateuser/',
    async(routeTo, routeFrom, resolve, reject) {
      if (validation.isUserLogin()) {
        const vueComponent = () => import('./pages/Home.vue');
        // resolve promise
        vueComponent().then((vc) => {
          // resolve with component
          resolve({ component: vc.default })
        });
      }
      else
      {
        const vueComponent = () => import('./pages/Activateuser.vue');
        // resolve promise
        vueComponent().then((vc) => {
          // resolve with component
          resolve({ component: vc.default })
        });
      }
    }
  },
  {
    path: '/map/',
    component: Map
  },
  {
    path: '/confirmdelivery/:address_id',
    async(routeTo, routeFrom, resolve, reject) {
      if (validation.isUserLogin()) {
        const vueComponent = () => import('./pages/Confirmdelivery.vue');
        // resolve promise
        vueComponent().then((vc) => {
          // resolve with component
          resolve({ component: vc.default })
        });
      }
      else
      {
        const vueComponent = () => import('./pages/Login.vue');
        // resolve promise
        vueComponent().then((vc) => {
          // resolve with component
          resolve({ component: vc.default })
        });
      }
    }
  },
  {
    path: '/account/',
    async(routeTo, routeFrom, resolve, reject) {
      if (validation.isUserLogin()) {
        const vueComponent = () => import('./pages/Account.vue');
        // resolve promise
        vueComponent().then((vc) => {
          // resolve with component
          resolve({ component: vc.default })
        });
      }
      else
      {
        const vueComponent = () => import('./pages/Login.vue');
        // resolve promise
        vueComponent().then((vc) => {
          // resolve with component
          resolve({ component: vc.default })
        });
      }
    }
  },
  {
    path: '/address/',
    async(routeTo, routeFrom, resolve, reject) {
      if (validation.isUserLogin()) {
        const vueComponent = () => import('./pages/Address.vue');
        // resolve promise
        vueComponent().then((vc) => {
          // resolve with component
          resolve({ component: vc.default })
        });
      }
      else
      {
        const vueComponent = () => import('./pages/Login.vue');
        // resolve promise
        vueComponent().then((vc) => {
          // resolve with component
          resolve({ component: vc.default })
        });
      }
    }
  },
  {
    path: '/selectaddress/',
    async(routeTo, routeFrom, resolve, reject) {
      if (validation.isUserLogin()) {
        const vueComponent = () => import('./pages/Selectaddress.vue');
        // resolve promise
        vueComponent().then((vc) => {
          // resolve with component
          resolve({ component: vc.default })
        });
      }
      else
      {
        const vueComponent = () => import('./pages/Login.vue');
        // resolve promise
        vueComponent().then((vc) => {
          // resolve with component
          resolve({ component: vc.default })
        });
      }
    }
  },
  {
    path: '/profile/',
    async(routeTo, routeFrom, resolve, reject) {
      if (validation.isUserLogin()) {
        const vueComponent = () => import('./pages/Profile.vue');
        // resolve promise
        vueComponent().then((vc) => {
          // resolve with component
          resolve({ component: vc.default })
        });
      }
      else
      {
        const vueComponent = () => import('./pages/Login.vue');
        // resolve promise
        vueComponent().then((vc) => {
          // resolve with component
          resolve({ component: vc.default })
        });
      }
    }
  },
  {
    path: '/shophome/',
    async(routeTo, routeFrom, resolve, reject) {
      const vueComponent = () => import('./pages/Shophome.vue');
      // resolve promise
      vueComponent().then((vc) => {
        // resolve with component
        resolve({ component: vc.default })
      });
    }
  },
  {
    path: '/index.html',
    async(routeTo, routeFrom, resolve, reject) {
      const vueComponent = () => import('./pages/Home.vue');
      // resolve promise
      vueComponent().then((vc) => {
        // resolve with component
        resolve({ component: vc.default })
      });
    }
  },
  {
    path: '(.*)',
    async(routeTo, routeFrom, resolve, reject) {
      const vueComponent = () => import('./pages/Home.vue');
      // resolve promise
      vueComponent().then((vc) => {
        // resolve with component
        resolve({ component: vc.default })
      });
    }
  }
];
