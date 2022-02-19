import Vuex from 'vuex'
import Vue from 'vue'
import Component from './modules/component'
import Profile from './modules/profile'

Vue.use(Vuex)
export default new  Vuex.Store({
    modules:{
        Component,
        Profile
    }
})