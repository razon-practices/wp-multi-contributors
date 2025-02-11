const log = require('log-beautify');

log.useSymbols = false;

log.setColors({
	success_: "green",
});

log.setTextColors({
	success_: 'white',
});

log.success_(`
                                                                     
                    Successfull Built 🎉                             
    Distributable plugin successfully built to ./dist folder         
                                                                     
`);