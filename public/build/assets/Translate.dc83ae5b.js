function r(n,a={}){let t=window._translations[n]||n;return Object.keys(a).forEach(o=>{t=t.replace(`:${o}`,a[o])}),t}export{r as _};
