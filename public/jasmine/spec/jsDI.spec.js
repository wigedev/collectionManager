describe('jsDI', function() {
    let container;
    beforeEach(function () {
        container = new jsDI();
    });
    describe('register(name, deps, func)', function () {
        it('throws if any argument is missing or the wrong type', function () {
            let badArgs = [
                [],
                ['name'],
                ['name', ['dep1', 'dep2']],
                ['name', function () {}],
                [[], ['dep1'], function () {}],
                ['name', [1, 2], function () {}],
                ['name', [], 'not a function']
            ];
            badArgs.forEach(function (args) {
                expect(function () {
                    container.register.apply(container, args);
                }).toThrow();
            });
        });
    });
    describe('get(name)', function () {
        it('returns undefined if name was not registered.', function () {
            expect(container.get('notDefined')).toBeUndefined();
        });
        it('returns the result of executing the named function', function () {
            let name = 'MyName',
                expectedReturn = 'something';
            container.register(name, [], function() { return expectedReturn});
            expect(container.get(name)).toBe(expectedReturn);
        });
        it('supplies dependencies', function () {
            let main = 'main',
                mainFunc,
                dep1 = 'dep1',
                dep2 = 'dep2';
            container.register(main, [dep1, dep2], function (dep1Func, dep2Func) {
                return function () {
                    return dep1Func() + dep2Func();
                }
            });
            container.register(dep1, [], function () {
                return function () {
                    return 1;
                };
            });
            container.register(dep2, [], function () {
                return function () {
                    return 2;
                };
            });
            mainFunc = container.get(main);
            expect(mainFunc()).toBe(3);
        })
    });
});