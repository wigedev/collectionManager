jsDI = function() {
    this.registrations = [];
};

jsDI.prototype.messages = {
    registerRequiresArgs: 'Register requires three args: name, dependencies, function'
}

jsDI.prototype.register = function(name, dependencies, func) {
    if (typeof name !== 'string'
    || !Array.isArray(dependencies)
    || typeof func !== 'function') {
        throw new Error(this.messages.registerRequiresArgs);
    }
    dependencies.forEach(function (dep) {
        if (typeof dep !== 'string') {
            throw new Error(jsDI.messages.registerRequiresArgs)
        }
    });
    this.registrations[name] = {deps: dependencies, func: func};
}

jsDI.prototype.get = function (name) {
    let self = this,
        inj = this.registrations[name],
        deps = [];
    if (typeof inj === 'undefined') {
        return undefined;
    }
    inj.deps.forEach(function (func) {
        let dependency = self.get(func);
        deps.push(typeof dependency === 'undefined' ? undefined : dependency);
    })
    return inj.func.apply(undefined, deps);
}