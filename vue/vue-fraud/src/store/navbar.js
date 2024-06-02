import { defineStore } from 'pinia'
import axios from 'axios'
export const useMyStore = defineStore({
    id: 'user',
    state: () => ({
      isAdmin: false,
      loginState: false,
      searchData: '',
      searchResult: [],
    }),
    actions: {
      async getSearchResult()
      {
        try{
        let result = await axios.post("http://127.0.0.1:8000/api/search", {
        query: this.searchData,
        });
        this.searchResult = result.data.data; 
      }
      catch(error)
      {
        if(error.response.status == 404)
        {
          this.searchResult = [];
        }
      }
      },

     setSearchData(value) {
      this.searchData = value;
    },

      setUserInfo() {
        this.loginState = true;
      },

      
    }
  });
