import { InspectorControls } from '@wordpress/block-editor';
import { useBlockProps } from '@wordpress/block-editor';
import ServerSideRender from '@wordpress/server-side-render';
import { PanelBody, SelectControl } from '@wordpress/components';
import { useSelect } from '@wordpress/data';

export default function Edit (props) {

  const { setAttributes, attributes: { blockPost } } = props;

  const posts = useSelect((select) => {
    return select('core').getEntityRecords('postType', 'employees');
  }, []);

  const postList = posts?.length && posts.map(post => {
    return {
      value: post.id,
      label: post.title.rendered
    }
  }) || []

  let employeeList = [{ value: null, label: 'Select an Employee' }, ...postList]

  const onChange = (post) => setAttributes({ blockPost: post })

  return (
    <>
      <InspectorControls>
        <PanelBody>
          <SelectControl
            label="Employee"
            value={blockPost}
            options={employeeList}
            onChange={post => onChange(post)}
          />
        </PanelBody>
      </InspectorControls>
      <div {...useBlockProps()}>
        {blockPost === 'empty' ?
          <div class="employee-card-placeholder">Please select an employee</div>
          :
          <ServerSideRender
            block="inpsyde/employee-block"
            attributes={props.attributes}
          />
        }
      </div>
    </>
  );
}
