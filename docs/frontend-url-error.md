
## Problem Description
When converting from Vue.js to React with Inertia.js, the dashboard navigation encountered a regex error due to incompatible route pattern matching.

###  Error Message

```js
// Uncaught SyntaxError: Invalid regular expression: /^*/vapor-ui(/(?<view>(.*)))?/?$/: Nothing to repeat

```
### Original Problematic Code


```js
<NavLink
href={route('dashboard')}
active={route().current('dashboard')}
>
    Dashboard
</NavLink>

```

### Method 1: Using Inertia's usePage (Recommended)

```jsx
// Import at the top of the file
import { Link, usePage } from '@inertiajs/react';

// Inside your component
const { url } = usePage();

<NavLink
href={route('dashboard')}
active={url === '/dashboard'}
>
    Dashboard
</NavLink>
```

### Understanding the Solution
#### Why It Works
- Eliminates problematic Vue.js route pattern matching
- Uses direct path comparison instead of regex patterns
- Properly integrates with React/Inertia.js routing system
- Maintains reactive state updates
#### Key Differences from Vue.js
- Vue.js uses $route.name for route matching
- React with Inertia.js needs different route checking approaches
- Pattern matching from Vue Router isn't compatible with React/Inertia
#### Best Practices
- Use usePage() hook for route checking when possible
- Avoid using route().current() which can cause regex errors
- Use direct path comparison for simple route matching
- Keep route checking logic simple and straightforward

Required Imports
```jsx
import { Link, usePage } from '@inertiajs/react';
import NavLink from '@/Components/NavLink';

```


