// https://github.com/ElMassimo/stimulus-vite-helpers/blob/main/src/index.ts

export const CONTROLLER_FILENAME_REGEX = /^(?:.*?(?:controllers|components)\/|\.?\.\/)?(.+)(?:[_-]controller\..+?)$/

export function registerControllers (application, controllerModules) {
    application.load(definitionsFromGlob(controllerModules))
}

export function definitionsFromGlob (controllerModules) {
    return Object.entries(controllerModules).map(definitionFromEntry).filter(value => value)
}

function definitionFromEntry ([name, controllerModule]) {
    const identifier = identifierForGlobKey(name)
    const controllerConstructor = controllerModule.default
    if (identifier && typeof controllerConstructor === 'function')
        return { identifier, controllerConstructor }
}

export function identifierForGlobKey (key) {
    const logicalName = (key.match(CONTROLLER_FILENAME_REGEX) || [])[1]
    if (logicalName)
        return logicalName.replace(/_/g, '-').replace(/\//g, '--')
}
