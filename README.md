# Silhouette

#### Dynamic user data for your static sites.

If you&rsquo;ve ever wanted to add a sprinkle of user data to your static sites, Silhouette is for you.

### Installation

1. Pull in the package via Composer

    ```
    composer require pattern/silhouette
    ```

2. Publish the config file

    ```
    php artisan vendor:publish --provider=Pattern\Silhouette\ServiceProvider
    ```

3. If you are using the Eloquent driver for your users, add your user model into your `.env` file

    ```
    SILHOUETTE_ELOQUENT_MODEL=App\User
    ```

### Usage

> Note: Silhouette relies on [AlpineJS](https://github.com/alpinejs/alpine) to work its magic. If you haven&rsquo;t already included Alpine in your project, you&rsquo;ll need to do that.

```
{{ silhouette attributes="name,email,initials,avatar" }}
    {{ silhouette:auth }}
        {{ silhouette:name }}
        {{ silhouette:email }}
        {{ silhouette:attribute }}
        ...
    {{ /silhouette:auth }}
    {{ silhouette:guest }}
        Content you would want a guest to see.
    {{ /silhouette:guest }}
{{ /silhouette}}
```

It all starts with the `{{ silhouette }}` tag pair. The attributes parameter is optional; by default Silhouette will attempt to return your user&rsquo;s name, email address, initials, and avatar.

Any content inside of the `{{ silhouette:auth }}` tag pair will only show if a user is authenticated. Inside of this tag pair you have access to either the default attributes or those you specified in the `attributes` parameter.

Likewise, any content inside of the `{{ silhouette:guest }}` pair will only show if your visitor is not an authenticated user.

### Advanced Usage

As stated above, Silhouette uses [AlpineJS](https://github.com/alpinejs/alpine) to fetch and display your user&rsquo;s data. It&rsquo;s a great way to sprinkle interactivity throughout your website without committing to a larger framework like [React](https://reactjs.org) or [Vue](https://vuejs.org) (or [Svelte](https://svelte.dev) or [Elm](https://elm-lang.org) or [Angular](https://angular.io) or&hellip; oh geez), but there is a slightly more advanced use case that might trip some people up: nested `x-data` objects.

If, for instance, you&rsquo;d like your users to be able to click on their avatar to toggle an &lsquo;Account&rsquo; menu, you might do something like this:

```
{{ silhouette }}
  {{ silhouette:auth }}
    <div x-data="{ show: false }">
      <button x-on:click="show = !show">
        <img src="{{ silhouette:avatar }}"
      </button>
      <template x-if="show">
        <nav>
          <p>Welcome, {{ silhouette:name }}</p>
          <a href="/account">Account</a>
          <a href="/logout">Logout</a>
        </nav>
      </template>
    </div>
  {{ /silhouette:auth }}
  {{ silhouette:guest }}
    <nav>
      <a href="/login">Login</a>
    </nav>
  {{ /silhouette:guest }}
{{ /silhouette }}
```

The problem with this approach is that because of the way Silhouette works, you&rsquo;ve just nested a new `x-data` context that is not aware of the `silhouette` object.

Alpine provides a way (through events and listeners) to communicate data across components (or even, as is the case here, within nested components). To get the above example to work, we need to add the `silhouette` object to our `x-data` and listen for changes to the parent&rsquo;s `silhouette` object (via an `x-on` directive):

```
{{ silhouette }}
  {{ silhouette:auth }}
    <div 
      x-data="{ show: false, silhouette: {} }" 
      x-on:silhouette.window="silhouette = $event.detail">
      <button x-on:click="show = !show">
        <img src="{{ silhouette:avatar }}"
      </button>
      <template x-if="show">
        <nav>
          <p>Welcome, {{ silhouette:name }}</p>
          <a href="/account">Account</a>
          <a href="/logout">Logout</a>
        </nav>
      </template>
    </div>
  {{ /silhouette:auth }}
  {{ silhouette:guest }}
    <nav>
      <a href="/login">Login</a>
    </nav>
  {{ /silhouette:guest }}
{{ /silhouette }}

```

### Credits

Many thanks to [Mike Martin](https://mike-martin.ca) for the excellent idea and some early testing.

### License

Licensed under the MIT license, see [LICENSE](https://github.com/pttrnco/silhouette/blob/main/LICENSE) for details.
